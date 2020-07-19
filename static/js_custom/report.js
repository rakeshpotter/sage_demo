var app = angular.module('app', []);
app.controller('ctrl', [
    '$scope',
    '$http',
    function ($scope, $http) {
        $scope.list = [];
        $scope.current_page = 1;
        $scope.total_page = 1;
        $scope.selected_index = -1;


        $scope.getPageList = function (page) {
            if (page < 1 || page > $scope.total_page)
                return;
            get('c=subscription&a=getList&page=' + page).then(function (data) {
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