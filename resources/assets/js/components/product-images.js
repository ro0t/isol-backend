import swal from 'sweetalert2';

const TYPES = { PRODUCT_IMAGES: 0, PAGE_IMAGES: 1};

export default class ProductImages {

    activate(swal) {

        this.swal = swal;
        this.container = document.querySelector('.product-images');
        this.type = TYPES.PRODUCT_IMAGES;

        if( this.container != null ) {

            this.overlay = document.querySelector('.product-images-upload');
            this.images = this.container.querySelector('.images');
            this.helper = this.container.querySelector('.add-helper');
            this.fileUpload = this.container.querySelector('input[type="file"]');

            this.registerComponent();
            this.checkForImages();
            this.hasImages();

        }

    }

    registerComponent() {

        this.button = this.container.querySelector('.add-image');
        this.button.addEventListener('click', this.openFileUpload.bind(this));

        this.fileUpload.addEventListener('change', this.fileInputChanged.bind(this));

    }

    checkForImages() {

        if( window.productImages !== undefined || window.pageImages !== undefined ) {

            this.type = window.productImages !== undefined ? TYPES.PRODUCT_IMAGES : TYPES.PAGE_IMAGES;

            let data = JSON.parse(this.type == TYPES.PRODUCT_IMAGES ? window.productImages : window.pageImages);

            if( data.length > 0 ) {

                this.displayImages(data);

            }

        }

    }

    hasImages() {

        this.displayHelper( !(this.images.children.length > 0) );

    }

    displayHelper(display) {

        this.helper.style.display = (display) ? 'block' : 'none';

    }

    displayOverlay(display) {
        this.overlay.style.display = (display) ? 'block' : 'none';
    }

    displayImages(images) {

        images.forEach((image) => {
            this.images.appendChild(this.pictureElement(image));
        })

        this.hasImages();

    }

    pictureElement(image) {

        let div = document.createElement('div');
        let img = document.createElement('img');

        img.setAttribute('src', image.image);

        if( image.main_image ) {
            div.setAttribute('class', 'active');
        }

        div.addEventListener('click', this.setMainImage.bind(this, image));
        div.addEventListener('contextmenu', this.deleteImage.bind(this, image, div));

        div.appendChild(img);

        return div;

    }

    setMainImage(image) {

        // Disable setting main image for Page Images
        if( this.type == TYPES.PAGE_IMAGES ) { return; }

        let children = this.images.children;

        for(let c in children) {
            let element = children.item(c);
            element.className = '';
        }

        event.target.className = 'active';

        axios.post('/product/setMainImage/' + image.product_id, {
            image: image.id
        }).then((res) => {
            note.success('Image', res.data.message);
        }).catch((err) => {
            note.error('Image error', err.response.data.message);
        });

    }

    deleteImage(image, parent) {

        event.preventDefault();

        swal({
          title: 'Are you sure?',
          text: "Do you want to remove this image from this product?",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#38465A',
          cancelButtonColor: '#AC5252',
          confirmButtonText: 'Delete!'
        }).then((result) => {

          if (result.value) {

              let deleteImageUrl = this.type == TYPES.PRODUCT_IMAGES ? '/product/deleteImage/' : '/pages/deleteImage/';

              axios.get( deleteImageUrl + image.id )
                .then((res) => {
                    parent.remove();
                    swal( 'Deleted!', 'Your file has been deleted.', 'success' );
                    this.hasImages();
                }).catch((err) => {
                    note.error('Oops', err.response.data.message);
                })

          }

        });

    }

    openFileUpload(e) {

        this.fileUpload.click();

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

        this.displayOverlay(true);

        axios.post(e.target.getAttribute('data-url'), data, config)
            .then((res) => {

                this.displayOverlay(false);
                note.success('Image upload', res.data.message);
                this.displayImages(res.data.images);

            })
            .catch((error) => {
                this.displayOverlay(false);
                note.error('Image upload error', error.response.data.message);
            })

    }

}
