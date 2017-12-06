
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
import frontpage from './editor/frontpage';

class IGW {

    init() {

        window.note = new note();

        // Todo replace all these functions with constructors, and run "new switches() instead of switches.activate().."
        switches.activate();
        styledInput.activate();
        textarea.activate();
        links.activate();
        datalists.activate();
        techInfo.activate();

        let pi = new productImages();
        pi.activate();

        // Only used for frontpage Editor
        let requestingFrontpageEditor = document.querySelector('.frontpage-container[init="true"]');
        if( requestingFrontpageEditor) { new frontpage(); }

    }

}

document.addEventListener('DOMContentLoaded', function() {
    (new IGW()).init();
});
