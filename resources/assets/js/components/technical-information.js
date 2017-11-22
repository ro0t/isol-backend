class TechnicalInformation {

    activate() {

        this.startIndex = 90000000;
        this.container = document.querySelector('.technical-description');

        if( this.container != null ) {

            this.lines = this.container.querySelector('.tech-description-lines');
            this.helper = this.container.querySelector('.add-helper');

            this.registerComponent();
            this.checkForExistingData();
            this.hasLines();

        }

    }

    registerComponent() {

        this.button = this.container.querySelector('.add-line');
        this.button.addEventListener('click', this.addLine.bind(this))

    }

    checkForExistingData() {

        if( window.technicalInformation !== undefined ) {

            let data = JSON.parse(window.technicalInformation);

            if( data.length > 0 ) {

                data.forEach((item) => { this.addLine(null, item.key, item.value); });

            }

        }

    }

    hasLines() {

        this.displayHelper( !(this.lines.children.length > 0) );

    }

    displayHelper(display) {

        this.helper.style.display = (display) ? 'block' : 'none';

    }

    addLine(e, val1, val2) {

        this.lines.appendChild(this.inputComponent(val1, val2));
        this.startIndex++;

        this.hasLines();

    }

    removeLine(e) {

        e.target.parentElement.remove();
        this.hasLines();

    }

    inputComponent(value1, value2) {

        let div = document.createElement('div');
        let leftInput = document.createElement('input');
        let rightInput = document.createElement('input');
        let remove = document.createElement('div');

        remove.setAttribute('class', 'remove');
        remove.addEventListener('click', this.removeLine.bind(this));

        leftInput = this.attributes(leftInput, 'left', 'tech_desc[' + this.startIndex + '][name]', 'Field name', value1);
        rightInput = this.attributes(rightInput, 'right', 'tech_desc[' + this.startIndex + '][value]', 'Field value', value2);

        div.appendChild(leftInput);
        div.appendChild(rightInput);
        div.appendChild(remove);

        return div;

    }

    attributes(input, cls, name, placeholder, value) {

        input.setAttribute('type', 'text');
        input.setAttribute('name', name);
        input.setAttribute('class', cls);
        input.setAttribute('placeholder', placeholder);

        if( value !== undefined && value != null ) {
            input.setAttribute('value', value);
        }

        return input;

    }

}

module.exports = new TechnicalInformation();
