$scope.loading = {};
$scope.changeEnableAudit = function () {
    console.log($scope);
    if (!!$scope.model.auditEnable) {
        $scope.model.auditTrack = "delete,login,save,view";
    } else {
        $scope.model.auditTrack = null;
    }
}

$scope.checkDb = function () {
    $scope.loading['db'] = true;
    $http({
        method: "post",
        url: Yii.app.createUrl("/dev/settings/db"),
        data: {
            'sys': $scope.model.dbSys,
            'host': $scope.model.dbHost,
            'dbname': $scope.model.dbName,
            'username': $scope.model.dbUser,
            'password': $scope.model.dbPass
        }
    }).success(function (data) {

        if (data !== 'null') {
            if (!$scope.errors) {
                $scope.errors = {};
            }
            $scope.errors['dbSys'] = [data];
        } else {
            if ($scope.errors != null && typeof $scope.errors['dbSys'] != 'undefined') {
                delete($scope.errors['dbSys']);
            }

        }
        $scope.model.errors = JSON.stringify($scope.errors);
        delete $scope.loading['db'];
    })
}

var tempSubmit = $scope.form.submit;
$scope.form.submit = function (that) {
    $scope.formSubmitting = true;
    $scope.checkDb();
    var unwatch = $scope.$watch('loading', function () {
        if ($scope.objectSize($scope.loading) == 0) {
            $scope.formSubmitting = false;
            unwatch();

            if ($scope.objectSize($scope.errors) == 0) {
                tempSubmit(that);
            }
        }
    }, true);

    return false;
}