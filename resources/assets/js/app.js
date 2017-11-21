
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('axios');
require('jquery/dist/jquery.min');

let note = require('Note.js')
let switches = require('./components/switch');
let styledInput = require('./components/input');
let textarea = require('./components/textarea');
let links = require('./components/links');
let datalists = require('./components/datalist');

class IGW {

    init() {

        window.note = new note();

        switches.activate();
        styledInput.activate();
        textarea.activate();
        links.activate();
        datalists.activate();

    }

}

document.addEventListener('DOMContentLoaded', function() {
    (new IGW()).init();
});
