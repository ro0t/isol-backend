
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import 'axios';
import 'jquery/dist/jquery.min';

import swal from 'sweetalert2';
import note from 'Note.js';
import switches from './components/switch';
import styledInput from './components/input';
import textarea from './components/textarea';
import links from './components/links'
import datalists from './components/datalist';
import techInfo from './components/technical-information';
import productImages from './components/product-images';

class IGW {

    init() {

        window.note = new note();

        switches.activate();
        styledInput.activate();
        textarea.activate();
        links.activate();
        datalists.activate();
        techInfo.activate();

        let pi = new productImages();
        pi.activate();

    }

}

document.addEventListener('DOMContentLoaded', function() {
    (new IGW()).init();
});
