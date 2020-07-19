var app = angular.module('app', []);
app.controller('ctrl', [
    '$scope',
    '$http',
    function ($scope, $http) {
        $scope.list = [];
        $scope.courseList = [];
        $scope.current_page = 1;
        $scope.total_page = 1;
        $scope.selected_index = -1;
        $scope.student = {
            id: '',
            first_name: '',
            last_name: '',
            dob: '',
            contact: ''
        };
        $scope.openNewRegistration = function () {
            openEditModel({
                id: 0,
                first_name: '',
                last_name: '',
                dob: '',
                contact: ''
            });
        }

        $scope.openEditRegistration = function (index) {
            openEditModel({...$scope.list[index]});
            $scope.selected_index = index;
        }

        $scope.saveModelData = function () {
            let action = ($scope.student.id == 0) ? 'add' : 'update&id=' + $scope.student.id;
            post('c=student&a=' + action, $scope.student).then(function (data) {
                if (data.status != 1) {
                    let arr = [];
                    for (let err in data.errors) {
                        arr.push(data.errors[err]);
                    }
                    return toast(arr.join('</li><li>'), 'Error !', 'danger')
                }
                closeEditModel();
                if ($scope.student.id == 0) {
                    $scope.list.unshift({...$scope.student, id: data.data.id});
                    if ($scope.list.length > 10)
                        $scope.list.pop();
                } else
                    $scope.list[$scope.selected_index] = {...$scope.student};
                toast('Student record saved.', 'Success !!', 'success');
            });
        }

        $scope.confirmRemove = function (index) {
            $scope.student = {...$scope.list[index]}
            $scope.selected_index = index;
            $('#confirmModal').modal();
        }

        $scope.deleteStudent = function () {
            post('c=student&a=remove', {id: $scope.student.id}).then(function (data) {
                if (data.status != 1) {
                    let arr = [];
                    for (let err in data.errors) {
                        arr.push(data.errors[err]);
                    }
                    return toast(arr.join('</li><li>'), 'Error', 'danger');
                }
                $('#confirmModal').modal('hide');
                //$scope.list.splice($scope.selected_index, 1);
                $scope.list[$scope.selected_index].deleted = true;
                toast('Student record removed.', 'Success', 'success');
            });
        }

        $scope.subscriptions = {
            list: [],
            newList: [],
            student: {},
            course: {},
            selectedIndex: 0,
            courseSelected: function () {
                if (!this.course.id)
                    return;
                this.newList.push({...this.course});
                this.course = {};
            },
            removeNewCourse: function (index) {
                this.newList.splice(index, 1);
            },
            isSubscribed: function (i) {
                return this.list.findIndex(course => {
                    return course.course_id == $scope.subscriptions.newList[i].id;
                }) != -1;
            },
            getCourseList: function () {
                return $scope.courseList.filter(course => {
                    return $scope.subscriptions.newList.findIndex(newCourse => {
                        return newCourse.id === course.id;
                    }) != -1 ? false : true;
                });
            },
            save: function () {
                if (this.newList.length == 0)
                    return toast('Please select atleast one course !', 'Alert', 'warning');

                let courses = [];
                this.newList.forEach(course => {
                    courses.push(course.id);
                });
                post('c=subscription&a=subscribe&id=' + this.student.id,
                        {courses: courses})
                        .then(function (data) {
                            if (data.status != 1) {
                                let arr = [];
                                for (let err in data.errors) {
                                    arr.push(data.errors[err]);
                                }
                                return toast(arr.join('</li><li>'), 'Error', 'danger');
                            }
                            toast('Subscription saved.', 'Success', 'success');
                            $scope.subscriptions.openModel($scope.selected_index);
                        });
            },
            unsubscribe: function () {
                post('c=subscription&a=remove',
                        {id: this.list[this.selectedIndex].id})
                        .then(function (data) {
                            if (data.status != 1) {
                                let arr = [];
                                for (let err in data.errors) {
                                    arr.push(data.errors[err]);
                                }
                                return toast(arr.join('</li><li>'), 'Error', 'danger');
                            }
                            toast('Subscription removed.', 'Success', 'success');
                            $scope.subscriptions.list.splice($scope.subscriptions.selectedIndex, 1);
                            $('#confirmUnSubModal').modal('hide');
                        });
            },
            openModel: function (index) {
                $scope.selected_index = index;
                this.student = {...$scope.list[index]};
                this.newList = [];
                if ($scope.courseList.length == 0) {
                    get('c=course&a=getAll').then(function (data) {
                        if (data.status != 1) {
                            let arr = [];
                            for (let err in data.errors) {
                                arr.push(data.errors[err]);
                            }
                            return toast(arr.join('</li><li>'), 'Error', 'danger');
                        } else if (data.data.length == 0)
                            return toast('No course is available to subscribe.', 'Alert', 'warning');
                        $scope.courseList = data.data;
                    });
                }
                get('c=subscription&a=courses&id=' + this.student.id).then(function (data) {
                    if (data.status != 1) {
                        let arr = [];
                        for (let err in data.errors) {
                            arr.push(data.errors[err]);
                        }
                        return toast(arr.join('</li><li>'), 'Error', 'danger');
                    }
                    $scope.subscriptions.list = data.data;
                    $('#subscriptionModal').modal();
                });
            },
            confirmUnsub: function (index) {
                this.selectedIndex = index;
                $('#confirmUnSubModal').modal();
            }
        };
        $scope.getPageList = function (page) {
            if (page < 1 || page > $scope.total_page)
                return;
            get('c=student&a=getList&page=' + page).then(function (data) {
                $scope.list = data.data;
                $scope.current_page = data.current_page;
                $scope.total_page = data.total_page;
//                console.log(data);
            });
        }
        $scope.getPageList(1);
        $scope.getPageNumbers = function () {
            let pages = [];
            let start = ($scope.current_page - 2 < 1) ? 1 : $scope.current_page - 2;
            let end = (start + 4 > $scope.total_page) ? $scope.total_page : start + 4;
            if ($scope.total_page >= 5 && end - start < 4) {
                start -= 4 - end + start;
                start = start < 1 ? 1 : start;
            }
            let i = start;
            while (pages.length < 5 && i <= end) {
                pages.push(i++);
            }
            return pages;
        }


        function openEditModel(data) {
            $scope.student = {...data};
            $('#editModal').modal();
        }
        function closeEditModel() {
            $('#editModal').modal('hide');
        }

        function get(path) {
            return $http.get('./services/index.php?' + path)
                    .then(function (data, status, headers, config) {
                        return data.data;
                    }, function (data, status, header, config) {
                        return {status: 0, error: 'Some internal error occured.'};
                    });
        }

        function post(path, data) {
            var data = $.param(data);
            //        console.log('---------------- POST --------------------');
            //        console.log(data);
            var config = {
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
                }
            }
            return $http.post('./services/index.php?' + path, data, config)
                    .then(function (data, status, headers, config) {
                        return data.data;
                    }, function (data, status, header, config) {
                        return {status: 0, error: 'Some internal error occured.'};
                    });
        }

    }
]);