<?php
/* 
@package SandipPlugin
  */

namespace Inc;

final class Init{

    public static function get_services(){
        return[
            Base\Enqueue:: class,
            Pages\AdminDashboard:: class,
            Base\CPTController::class,
            Base\TAXController::class,
            Base\MediaController::class,
            Base\EmbedController::class,
        ];
    }

    public static function regsiter_servicies()
    {
        foreach(self::get_services() as $class){
            $service = self::initialise($class);

            if(method_exists($service, 'register')){
                $service->register();
            }
        }
    }

    public function initialise($class){
        return new $class;
    }  
}