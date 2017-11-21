let classie = require('desandro-classie');

class Links {

    activate() {

        this.links = document.querySelectorAll('a');

        this.links.forEach((link) => {

            // Delete link?
            if( classie.has(link, 'delete') ) {
                this.attachDeleteConfirmationEvent(link);
            }

        })

    }

    attachDeleteConfirmationEvent( link ) {

        link.addEventListener('click', (e) => {

            let check = confirm('Are you sure you want to delete this record?');

            if(!check) {
                e.preventDefault();
                return;
            }

        })

    }

}

module.exports = new Links();
