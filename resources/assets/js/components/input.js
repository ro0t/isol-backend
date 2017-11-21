let classie = require('desandro-classie');

class StyledInput {

    activate() {

        this.inputs = document.querySelectorAll('.input');

        this.inputs.forEach((input) => {

            let store = { input: input, child: input.querySelector('.input__field') }

            if( classie.has(store.input, 'input--image') || classie.has(store.input, 'textarea')) {
                return;
            } else {
                this.checkValue(store);
                this.attachEvent(store);
            }
        })

    }

    checkValue( store ) {

        if( store.child.value.length > 0 ) {
            classie.add( store.input, 'input--filled');
        } else {
            classie.remove( store.input, 'input--filled');
        }

    }

    attachEvent( store ) {

        store.input.addEventListener('keypress', (e) => {
            this.checkValue(store)
        })

        store.input.addEventListener('focusout', (e) => {
            this.checkValue(store)
        })

    }

}

module.exports = new StyledInput();
