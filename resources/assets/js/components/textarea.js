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
                autogrow: true,
                removeformatPasted: true
            }

        }

    }

    initialize(textarea, options) {

        options = options ? options : {
            btnsDef: {
                // Customizables dropdowns
                image: {
                    dropdown: ['insertImage', 'upload'],
                    ico: 'insertImage'
                }
            },
            btns: [
                ['viewHTML'],
                ['undo', 'redo'], // Only supported in Blink browsers
                ['formatting'],
                ['strong', 'em', 'del'],
                //['superscript', 'subscript'],
                ['link'],
                ['image'],
                ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
                ['unorderedList', 'orderedList'],
                ['horizontalRule'],
                ['removeformat'],
                ['fullscreen']
            ],
            //btns: ['strong','italic','underline','insertImage'],
            autogrow: true,
            removeformatPasted: true
        };

        $(textarea).trumbowyg(options);
    }

}

module.exports = new Textarea();
