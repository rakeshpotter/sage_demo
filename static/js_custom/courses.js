var app = angular.module('app', []);
app.controller('ctrl', [
    '$scope',
    '$http',
    function ($scope, $http) {
        $scope.list = [];
        $scope.current_page = 1;
        $scope.total_page = 1;
        $scope.selected_index = -1;

        $scope.course = {
            id: '',
            name: '',
            details: ''
        };

        $scope.openNewRegistration = function () {
            openEditModel({
                id: 0,
                name: '',
                details: ''
            });
        }

        $scope.openEditRegistration = function (index) {
            openEditModel({...$scope.list[index]});
            $scope.selected_index = index;
        }

        $scope.saveModelData = function () {
            let action = ($scope.course.id == 0) ? 'add' : 'update&id=' + $scope.course.id;
            post('c=course&a=' + action, $scope.course).then(function (data) {
                if (data.status != 1) {
                    let arr = [];
                    for (let err in data.errors) {
                        arr.push(data.errors[err]);
                    }
                    toast(arr.join('</li><li>'), 'Error !', 'danger')
                } else {
                    closeEditModel();
                    if ($scope.course.id == 0) {
                        $scope.list.unshift({...$scope.course, id: data.data.id});
                        if ($scope.list.length > 10) {
                            if ($scope.total_page == 1)
                                $scope.getPageList(1);
                            else
                                $scope.list.pop();
                        }
                    } else
                        $scope.list[$scope.selected_index] = {...$scope.course};
                    toast('Course record saved.', 'Success !!', 'success')
                }
            });
        }

        $scope.confirmRemove = function (index) {
            $scope.course = {...$scope.list[index]}
            $scope.selected_index = index;
            $('#confirmModal').modal();
        }

        $scope.deleteCourse = function () {
            post('c=course&a=remove', {id: $scope.course.id}).then(function (data) {
                if (data.status != 1) {
                    let arr = [];
                    for (let err in data.errors) {
                        arr.push(data.errors[err]);
                    }
                    toast(arr.join('</li><li>'), 'Error', 'danger');
                } else {
                    $('#confirmModal').modal('hide');
                    //$scope.list.splice($scope.selected_index, 1);
                    $scope.list[$scope.selected_index].deleted = true;
                    toast('Course record removed.', 'Success', 'success');
                }
            });
        }


        $scope.getPageList = function (page) {
            if (page < 1 || page > $scope.total_page)
                return;
            get('c=course&a=getList&page=' + page).then(function (data) {
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
            $scope.course = {...data};
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