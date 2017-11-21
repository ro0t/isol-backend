class Switches {

    activate() {

        this.togglers = document.querySelectorAll('.switch input[type="checkbox"]');

        this.togglers.forEach((toggler) => {
            this.attachEvent(toggler)
        })

    }

    attachEvent( toggler ) {

        toggler.addEventListener('change', (e) => {
            this.updateValue( toggler.checked, toggler.getAttribute('data-url') )
        })

    }

    updateValue( value, url ) {

        axios.post(url, { checked: value }).then((response) => {

            note.success('Success', response.data.message, { duration: 6 });

        }).catch((error) => {

            note.error('Error', response.data.message);

        })

    }

}

module.exports = new Switches();
