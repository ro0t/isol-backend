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
        if( $price == null ) {
            return 'N/A';
        }

        return number_format($price, 0, ',', '.') . ' kr.';

    }

}

if( !function_exists('concat_str') ) {
    function concat_str($a, $b) {
        return $a . $b;
    }
}

if( !function_exists('drawOption') ) {
    function drawOption($id, $label, $selected, $parentName = '') {
        $isSelected = $id == $selected ? 'selected' : '';
        $categoryLabel = $parentName != '' ? $parentName . ' » ' . $label : $label;
        return "<option value='{$id}' {$isSelected}>{$categoryLabel}</option>";
    }
}

if ( !function_exists('recursive_product_categories') ) {

    function recursive_product_categories($selectedValue, $categories, $parentName = '') {
        $html = '';

        if(count($categories) > 0) {
            foreach($categories as $category) {
                $html = concat_str($html, drawOption($category->id, $category->name, $selectedValue, $parentName));

                // loop children?
                if($category->childCount > 0) {
                    $html = concat_str($html, recursive_product_categories($selectedValue,
                        $category->children,
                        $category->name
                    ));
                }
            }
        }

        return $html;
    }

}