import swal from 'sweetalert2';

export default class FrontpageSlideshow {

    constructor() {

        this.fileInput = document.getElementById('frontpage-slideshow');
        this.imageContainer = null;
        this.fileInput.addEventListener('change', (e) => { this.fileInputChanged(e) })

    }

    openFileUpload() {
        this.fileInput.click();
    }

    displayImages(images, sources) {

        images.forEach( i => {

            let img = document.createElement('img');
            img.setAttribute('src', (sources === undefined) ? i.image : i);

            this.imageContainer.appendChild(img);

            img.addEventListener('click', this.deleteImage.bind(this, img));

        })

    }

    deleteImage(image) {

        event.preventDefault();

        swal({
          title: 'Are you sure?',
          text: "Do you want to remove this image from the slideshow?",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#38465A',
          cancelButtonColor: '#AC5252',
          confirmButtonText: 'Delete!'
        }).then((result) => {

          if (result.value) {
              image.remove();
          }

        });

    }

    getSaveJson() {

        let images = this.imageContainer.querySelectorAll('img');
        let sources = [];

        images.forEach( img => { sources.push(img.getAttribute('src')); });

        return sources;

    }

    fileInputChanged(e) {

        let files = e.target.files;
        let data = new FormData();

        if( files.length > 5 ) {
            return note.error('Max 5 images', 'You can only upload 5 images.');
        }

        if( !files.length ) {
            return;
        }

        for(var i = 0; i < files.length; i++) {

            let file = files.item(i);
            data.append(`images[${i}]`, file, file.name);

        }

        const config = {
            headers: {
                'content-type': 'multipart/form-data'
            }
        }

        if(this.imageContainer == null) {
            return note.error('No image container available, please refresh the page and try again.');
        }

        axios.post(e.target.getAttribute('data-url'), data, config)
            .then((res) => {

                note.success('Image upload', res.data.message);
                this.displayImages(res.data.images);

            })
            .catch((error) => {
                note.error('Image upload error', error.response.data.message);
            })

    }

}
