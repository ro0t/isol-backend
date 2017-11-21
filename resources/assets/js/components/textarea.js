let classie = require('desandro-classie');

class Textarea {

    activate() {

        this.textareas = document.querySelectorAll('.textarea.html');

        this.textareas.forEach((textarea) => {
            this.initialize(textarea.querySelector('textarea'), this.generateOptionsFor(textarea.getAttribute('data-options')))
        })

    }

    generateOptionsFor(string) {

        if(string && string.length > 0) {

            return {
                btns: string.split('|'),
                autogrow: true
            }

        }

    }

    initialize(textarea, options) {

        options = options ? options : {
            //btns: ['strong','italic','underline','insertImage'],
            autogrow: true
        };

        $(textarea).trumbowyg(options);
    }

}

module.exports = new Textarea();
