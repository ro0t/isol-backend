<?php

if( !function_exists('isActive') ) {

    function isActive( $check ) {

        $path = request()->getPathInfo();

        if( $check === '/' ) {

            return (strlen($path) > 1) ? '' : 'active';

        } else {

            return (strpos( $path, $check ) !== false) ? 'active' : '';

        }

    }

}

if( !function_exists('isChecked') ) {

    function isChecked( $check ) {

        return ($check) ? 'checked="true"' : '';

    }

}

if( !function_exists('fvalue') ) {

    function fvalue( $object, $key ) {

        if( isset($object) ) {
            return $object[$key];
        }

        return old($key);

    }

}

if( !function_exists('fselectvalue') ) {

    function fselectvalue( $value, $object, $key ) {

        if( isset($object) ) {
            return $object[$key] == $value ? 'selected' : '';
        }

        return old($key) == $value ? 'selected' : '';

    }

}

if( !function_exists('finput') ) {

    function finput( $name, $label, $value, $description = '', $required = false, $type = 'text' ) {

        return view('components.finput')
            ->with('type', $type)
            ->with('required', $required)
            ->with('name', $name)
            ->with('label', $label)
            ->with('value', $value)
            ->with('description', $description);

    }

}

if( !function_exists('ftextarea') ) {

    function ftextarea( $name, $label, $value, $options = '', $required = false ) {

        return view('components.ftextarea')
            ->with('name', $name)
            ->with('label', $label)
            ->with('value', $value)
            ->with('required', $required)
            ->with('options', $options);

    }

}

if( !function_exists('fimage') ) {

    function fimage( $name, $label, $value, $accept = 'image/png,image/jpg' ) {

        return view('components.fimage')
            ->with('name', $name)
            ->with('label', $label)
            ->with('value', $value)
            ->with('accept', $accept);

    }

}

if( !function_exists('ffile') ) {

    function ffile( $name, $label, $value, $accept = '.csv' ) {

        return view('components.ffile')
            ->with('name', $name)
            ->with('label', $label)
            ->with('value', $value)
            ->with('accept', $accept);

    }

}

if( !function_exists('fcreate') ) {

    function fcreate( $route, $text ) {

        return view('components.fcreate')
            ->with('route', $route)
            ->with('text', $text);

    }

}

if( !function_exists('ferrors') ) {

    function ferrors() {

        return view('components.errors');

    }

}

if( !function_exists('formatPrice') ) {

    function formatPrice( $price ) {

        return number_format($price, 0, ',', '.') . ' kr.';

    }

}
