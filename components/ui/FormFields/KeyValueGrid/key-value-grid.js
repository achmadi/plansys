app.directive('keyValueGrid', function($timeout) {
    return {
        require: '?ngModel',
        scope: true,
        compile: function(element, attrs, transclude) {
            if (attrs.ngModel && !attrs.ngDelay) {
                attrs.$set('ngModel', '$parent.' + attrs.ngModel, false);
            }

            return function($scope, $el, attrs, ctrl) {

                // when ng-model is changed from inside directive
                $scope.change = function() {
                    $scope.value = cleanJSON($scope.value);
                    $scope.json = prettifyJSON(unformatJSON($scope.value));

                    if (typeof ctrl != 'undefined') {
                        $timeout(function() {
                            ctrl.$setViewValue(unformatJSON($scope.value));
                            
                            if (typeof attrs.ngChange == "undefined") {
                                $scope.$parent.save();
                            }
                        }, 0);
                    }
                };

                $scope.changeJSON = function() {
                    $scope.json_error = '';
                    try {
                        $scope.value = JSON.parse($scope.json);
                    } catch (e) {
                        $scope.json_error = e.message;
                    }

                    if ($scope.json_error == '') {
                        $scope.value = formatJSON(JSON.parse($scope.json));
                        if (typeof ctrl != 'undefined') {
                            $timeout(function() {
                                ctrl.$setViewValue(unformatJSON($scope.value));
                                $scope.$parent.save();
                            }, 0);
                        }
                    }
                };

                // set default value, executed when one formfield is selected
                function filterKeyValue(key, value) {
                    var filtered_key = key;
                    var filtered_value = typeof value == "undefined" ? "" : value.toString();

                    if (!$scope.allowSpace) {
                        filtered_key = filtered_key.replace(/\s*/g, '');
                    }

                    if (!$scope.allowDoubleQuote) {
                        filtered_key = filtered_key.replace(/"/g, '\'');
                        filtered_value = filtered_value.replace(/"/g, '\'');
                    }

                    return {
                        key: filtered_key,
                        value: filtered_value
                    };
                }

                function formatJSON(raw_value) {
                    var filtered = [];
                    for (var key in raw_value) {
                        if (!$scope.allowEmpty && raw_value[key].trim() == "")
                            continue;
                        
                        if ($scope.allowEmpty &&  raw_value[key].trim() == "" && raw_value[value].trim() == "") 
                            continue;

                        var item = filterKeyValue(key, raw_value[key]);
                        filtered.push(item);
                    }
                    filtered.push({key: "", value: ""});
                    return filtered;
                }

                function prettifyJSON(json) {
                    return JSON.stringify(JSON.parse(JSON.stringify(json)), null, 2);
                }

                function cleanJSON(raw) {
                    var list = [];
                    for (i in raw) {
                        if (!$scope.allowEmpty && raw[i].key.trim() == "")
                            continue;
                        
                        if ($scope.allowEmpty && raw[i].key.trim() == "" && raw[i].value.trim() == "") 
                            continue;

                        var item = filterKeyValue(raw[i].key, raw[i].value);
                        list.push(item);
                    }
                    list.push({key: "", value: ""});
                    return list;
                }

                function unformatJSON(raw) {
                    var list = {};
                    for (i in raw) {
                        if (!$scope.allowEmpty && raw[i].key.trim() == "")
                            continue;
                        
                        if ($scope.allowEmpty && raw[i].key.trim() == "" && raw[i].value.trim() == "") 
                            continue;

                        var item = filterKeyValue(raw[i].key, raw[i].value);

                        list[item.key] = item.value;
                    }
                    return list;
                }


                // when ng-model is changed from outside directive
                if (typeof ctrl != 'undefined') {
                    ctrl.$render = function() {
                        if ($scope.inEditor && !$scope.$parent.fieldMatch($scope))
                            return;

                        if (typeof ctrl.$viewValue != 'undefined') {
                            $scope.value = formatJSON(ctrl.$viewValue);
                            $scope.json = prettifyJSON(unformatJSON($scope.value));
                        }
                    };
                }


                $scope.fieldName = $el.find("data[name=field_name]").html().trim();
                $scope.modelClass = $el.find("data[name=model_class]").html();
                $scope.show = $el.find("data[name=field_show]").html().trim() == 'Hide' ? false : true;
                $scope.allowEmpty = $el.find("data[name=allow_empty]").html().trim() == 'No' ? false : true;
                $scope.allowSpace = $el.find("data[name=allow_space]").html().trim() == 'No' ? false : true;
                $scope.allowDoubleQuote = $el.find("data[name=allow_dquote]").html().trim() == 'No' ? false : true;
                $scope.mode = "grid";
                $scope.inEditor = typeof $scope.$parent.inEditor != "undefined";
                $scope.json_error = "";
                $scope.value = formatJSON(JSON.parse($el.find("data[name='value']").text().trim()));
                $scope.json = prettifyJSON(unformatJSON($scope.value));

                // if ngModel is present, use that instead of value from php
                if (attrs.ngModel) {
                    $timeout(function() {
                        var ngModelValue = $scope.$eval(attrs.ngModel);
                        if (typeof ngModelValue != "undefined") {
                            $scope.value = formatJSON(ngModelValue);
                            $scope.json = prettifyJSON(unformatJSON($scope.value));
                        }
                    }, 0);
                }
            }
        }
    };
});