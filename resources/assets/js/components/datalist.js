class Datalist {

    activate() {

        this.datalinks = document.querySelectorAll('datalist');

        this.datalinks.forEach((datalist) => {
            this.attachEvent(datalist);
        })

    }

    attachEvent(datalist) {

        this.url = datalist.getAttribute('url');
        this.input = document.getElementById(datalist.getAttribute('input'));

        // Check if we need to populate a result field
        this.result = ((res = datalist.getAttribute('result')) !== undefined) ? document.getElementById(res) : null;

        this.input.addEventListener('keyup', () => {
            this.input.value.length > 2 ? this.search(datalist, this.input.value) : ''
        });

        this.input.addEventListener('keydown', (e) => {
            console.log(e.key)
        });

        this.input.addEventListener('blur', () => {
            this.input.value.length > 0 && this.result != null ? this.populate(datalist, this.input.value) : ''
        });

    }

    search(datalist, value) {

        axios.get(this.url + '?q=' + encodeURIComponent(value))
            .then((response) => { if( response.data.length > 0 ) { this.insertOptions(response.data, datalist); } })
            .catch((error) => { console.error(error); });

    }

    insertOptions(array, element) {

        // Reset the datalist
        element.innerHTML = '';

        array.forEach(option => {
            element.innerHTML += `<option value="${option.nav_product_id}" data-title="${option.nav_product_title}">${option.nav_product_title}</option>`;
        });

    }

    populate(datalist, value) {

        datalist.childNodes.forEach(node => {

            if(node.value == value) {
                this.result.value = node.getAttribute('data-title');
            }

        });

    }

}

module.exports = new Datalist();
