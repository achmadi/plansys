<?php
        /**
        * 
        */
        class EmailGenerator extends CComponent
        {
            
            public static function listMenuTree() {
                    $dir    = Yii::getPathOfAlias("application.views.layouts.email");
                    $appDir = Yii::getPathOfAlias("app.models");

                    $devItems = glob($dir . DIRECTORY_SEPARATOR . "*");
                    $appItems = glob($appDir . DIRECTORY_SEPARATOR . "*");

                    $items  = [];
                    $models = [];
                    if (Setting::get('app.mode') == "plansys") {
                        foreach ($devItems as $k => $m) {
                            $m = str_replace($dir . DIRECTORY_SEPARATOR, "", $m);
                            $m = str_replace('.php', "", $m);

                            $devItems[$k] = [
                                'type' => 'plansys',
                                'label' => $m,
                                'icon' => 'fa fa-cube',
                                'class' => 'application.views.layouts.email' . $m,
                                'class_path' => 'application.views.layouts.email',
                                'type' => 'dev',
                                'active' => @$_GET['active'] == 'plansys.' . $m,
                                'url' => Yii::app()->controller->createUrl('/dev/email/index', [
                                    'active' => 'plansys.' . $m,
                                ]),
                                'target' => 'col2',
                            ];
                        }

                        $models[] = [
                            'type' => 'plansys',
                            'label' => 'Plansys',
                            'items' => $devItems,
                        ];
                    }

                    foreach ($appItems as $k => $m) {
                        $m = str_replace($appDir . DIRECTORY_SEPARATOR, "", $m);
                        $m = str_replace('.php', "", $m);

                        $appItems[$k] = [
                            'type' => 'app',
                            'label' => $m,
                            'icon' => 'fa fa-cube',
                            'class' => 'app.models.' . $m,
                            'class_path' => 'app.models',
                            'exist' => (class_exists($m)) ? 'yes' : 'no',
                            'type' => 'app',
                            'active' => @$_GET['active'] == 'app.' . $m,
                            'url' => Yii::app()->controller->createUrl('/dev/genModel/index', [
                                'active' => 'app.' . $m,
                            ]),
                            'target' => 'col2',
                        ];
                    }
                    $models[] = [
                        'type' => 'app',
                        'label' => 'App',
                        'items' => $appItems,
                    ];

                    return $models;
                }
                    }
?>