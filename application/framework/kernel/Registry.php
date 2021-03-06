<?php


class Registry
{

    private static $controllers = [];

    public static function initialize()
    {        
        $path_files = PATH_APP . 'registry' .DS ;
        $files = scandir($path_files);

        foreach ($files as $key => $value) {
            $path = $path_files.'/'.$value;

            if( strpos($value, '.php') ){
                if(is_file($path) AND is_readable($path)){
                    self::$controllers[str_replace('.php','',$value)] = include_once $path;
                }
            }

        }
    }


    public static function get($key)
    {
        if( isset(self::$controllers[$key]) ){
            $r = self::$controllers[$key];
            return $r;
        }   
    }


    /** 
     * -----------------------------------------------------------------------
     * Registry GET
     * ------------------------------------------------------------------------
     */
    public static function get_all()
    {
        $registry = self::$controllers;
        asort($registry);
  
        $arr = array_reverse($registry, true); 
        $arr['dashboard'] = [
            'text' => 'Dashboard',
            'icon'=> 'fa fa-dashboard',
            'module' => 'backend',
            'methods' => []
        ]; 
        $registry = array_reverse($arr, true);
        return $registry;
    }

    /** 
     * -----------------------------------------------------------------------
     * GET Menu
     * -----------------------------------------------------------------------
     * Dvuelve un listado organizado del menu de la aplciación
     */
    public static function get_menu()
    {
        $registry = self::$controllers;
        asort($registry);
  
        $arr = array_reverse($registry, true); 
        $arr['dashboard'] = [
            'text' => 'Dashboard',
            'icon'=> 'fa fa-dashboard',
            'module' => 'backend',
        ];
        $registry = array_reverse($arr, true);

        foreach (array_reverse($arr, true) as $mdule_name => $module_attr) {
            $temp = [
                'text' => isset($module_attr['text']) ? $module_attr['text'] : '',
                'icon' => isset($module_attr['icon']) ? $module_attr['icon'] : '',
                'module' => isset($module_attr['module']) ? $module_attr['module'] : '',
                'alias_url' => isset($module_attr['alias_url']) ? $module_attr['alias_url'] : NULL,
                'info' => isset($module_attr['info']) ? $module_attr['info'] : '',
            ];

            if( isset($module_attr['submodules']) AND count($module_attr['submodules']) ){
                $registry[$mdule_name]['submodules'] = [];
                foreach ($module_attr['submodules'] as $key => $value){
                    $registry[$mdule_name]['submodules'][$value] = [
                        'text' => isset($registry[$value]['text']) ? $registry[$value]['text'] : '',
                        'icon' => isset($registry[$value]['icon']) ? $registry[$value]['icon'] : '',
                        'module' => isset($registry[$value]['module']) ? $registry[$value]['module'] : '',
                        'alias_url' => isset($registry[$value]['alias_url']) ? $registry[$value]['alias_url'] : NULL,
                        'info' => isset($registry[$value]['info']) ? $registry[$value]['info'] : '',
                    ];    
                    unset($registry[$value]);
                }                
            }
        }

        return $registry;
    }


    /** 
     * -----------------------------------------------------------------------
     * GET Menu
     * ------------------------------------------------------------------------
     */
    public static function get_modules()
    {
        $registry = self::$controllers;
        asort($registry);
  
        $arr = array_reverse($registry, true); 
        $arr['dashboard'] = [
            'text' => 'Dashboard',
            'icon'=> 'fa fa-dashboard',
            'module' => 'backend',
        ];
        $registry = array_reverse($arr, true);

        foreach (array_reverse($arr, true) as $mdule_name => $module_attr) {
            if( isset($module_attr['modules']) AND count($module_attr['modules']) ){
                unset($registry[$mdule_name]);
            }
        }

        return $registry;
    }


    public static function get_registry_of_modules_json()
    {
        $registry = self::$controllers;
        asort($registry);
  
        $arr = array_reverse($registry, true); 
        $arr['dashboard'] = [
            'text' => 'Dashboard',
            'icon'=> 'fa fa-dashboard',
            'module' => 'backend',
        ];

        $registry = array_reverse($arr, true);
        foreach (array_reverse($arr, true) as $mdule_name => $module_attr) 
        {
            if( isset($module_attr['fields_info']) )
            {
                foreach ($module_attr['fields_info'] as $fields_info => $fields_info_attr)
                {
                    $registry[$mdule_name]['fields_info'][$fields_info]['access'] = 0;
                }
            }
        }
        $registry = json_encode($registry, JSON_PRETTY_PRINT);

        return $registry;
    }

}

?>