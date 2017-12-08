import '../jquery-ui/jquery-ui.js';
import swal from 'sweetalert2';
import FrontpageSlideshow from './frontpage.slideshow';

const ModuleType = {
    MANUFACTURERS: 'MANUFACTURER',
    NEWS: 'NEWS',
    SLIDESHOW: 'SLIDESHOW'
};

export default class Frontpage {

    constructor() {

        let self = this;

        $('.frontpage-sortable').sortable({
            axis: 'x',
            update: function(event, ui) {
                let data = $(this).sortable('serialize'),
                    rowId = $(this).data('row-id');

                axios.post('/pages/frontpage/order/' + rowId, data)
                    .then( res => { /* 😍 It worked 😍 */ })
                    .catch( e => {
                        swal( 'D@mn 😲', 'Couldn\'t save tile positions, please check console for debug logs.', 'error' );
                        console.error('Debug', e);
                    });
            }
        });

        this.currentWorkingId = 0;
        this.currentWorkingType = null;
        this.currentWorkingTile = null;
        this.currentWorkingData = {};

        this.editor         = document.querySelector('.frontpage-type-editor');
        this.underlay       = this.editor.querySelector('.underlay');
        this.cancel         = this.editor.querySelector('.cancel');
        this.save           = this.editor.querySelector('.save');
        this.options        = this.editor.querySelector('.module-options');
        this.selectType     = this.editor.querySelector('select[name="type"]');

        // Loop through tiles and set their event listener
        let tiles          = document.querySelectorAll('.frontpage-sortable .tile');
        tiles.forEach( (tile) => { tile.addEventListener('click', this.openModal.bind(this, tile)) });

        // If the user chooses a new type, load new options
        this.selectType.addEventListener('change', (e) => {
            this.currentWorkingType = e.target.value;
            this.setupOptions();
        });

        //
        this.save.addEventListener('click', this.saveModule.bind(this));

        // Closers
        this.underlay.addEventListener('click', this.closeModal.bind(this));
        this.cancel.addEventListener('click', this.closeModal.bind(this));

        this.fps = new FrontpageSlideshow();

    }

    openModal(tile) {

        this.currentWorkingTile             = tile;
        this.currentWorkingId               = $(tile).data('id');
        this.currentWorkingType             = $(tile).data('type');
        this.currentWorkingData             = $(tile).data('tile');

        // Set the select value to correct state and load possible options.
        this.selectType.value = this.currentWorkingType;

        this.setupOptions();
    }

    setupOptions() {

        // Clear the options field
        this.options.innerHTML = '';

        // Generic callback for the options loader
        let callback = (elems) => {
            this.options.appendChild(elems);
            $(this.editor).show();
        };

        // Load the module options into the element.
        switch(this.currentWorkingType) {
            case ModuleType.MANUFACTURERS: {
                this.loadManufacturerOptions(this.currentWorkingData, callback);
                break;
            }

            case ModuleType.NEWS: {
                this.loadNewsOptions(this.currentWorkingData, callback);
                break;
            }

            case ModuleType.SLIDESHOW: {
                console.log('in')
                this.loadSlideshowOptions(this.currentWorkingData, callback);
                break;
            }
        }


    }

    saveModule() {

        let moduleId = this.currentWorkingId;

        switch(this.currentWorkingType) {
            case ModuleType.MANUFACTURERS: {
                return this.manufacturerSave( moduleId );
            }

            case ModuleType.NEWS: {
                return this.newsSave( moduleId );
            }

            case ModuleType.SLIDESHOW: {
                return this.slideshowSave( moduleId );
            }
        }

    }

    closeModal() {
        $(this.editor).hide()
    }

    loadManufacturerOptions(data, callback) {

        let elems = document.createElement('div');

        // Banner image uploader and possibility of selecting a manufacturer
        let label = document.createElement('label');
        label.className = 'select--label';
        label.innerHTML = 'Select manufacturer';

        let dSelect = document.createElement('div');
        dSelect.className = 'select';

        let select = document.createElement('select');
        select.setAttribute('name', 'manufacturer_id');

        elems.appendChild(label);
        elems.appendChild(dSelect)

        // Load manufacturers and put in the options
        axios.get('/api/manufacturers')
            .then( res => {

                res.data.manufacturers.forEach( mf => {

                    let option = document.createElement('option');
                    option.setAttribute('value', mf.id);
                    option.innerHTML = mf.name;

                    select.appendChild(option);

                });

                select.value = data.manufacturer;
                this.currentManufacturer = data.manufacturer;

                select.addEventListener('change', this.updatedManufacturerSelection.bind(this, select));

                dSelect.appendChild(select);
                callback(elems);

            })
            .catch( e => {
                swal( 'Ouch', 'Couldn\'t fetch manufacturers, please check console for debug logs.', 'error' );
                console.error('Debug', e);
            })

    }

    updatedManufacturerSelection(select) {
        this.currentManufacturer = select.value;
    }

    loadNewsOptions(data, callback) {

        // No need for additional data, this module will automatically load the last 5 articles on the server side.
        let description = document.createElement('p');

        description.style.textAlign = 'center';
        description.style.fontSize = '14px';

        description.innerHTML = 'Show latest 5 news posts';

        callback(description);

    }

    loadSlideshowOptions(data, callback) {

        let elems = document.createElement('div');
        elems.className = 'frontpage-slideshow';

        let input = document.createElement('div');
        input.className = 'input';

        input.innerHTML = '<label>Slideshow images</label><span class="input__description" style="max-width: 100%;">Click an image to remove the image.</span>';

        let images = document.createElement('div');
        images.className = 'images';

        this.fps.imageContainer = images;

        if(data.images !== undefined) {
            // Add current images to the container, if data exists already.
            this.fps.displayImages(data.images, true);
        }

        elems.appendChild(input);
        elems.appendChild(images);

        let addImage = document.createElement('div');
        addImage.className = "add-image";
        addImage.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" width="512px" height="512px" viewBox="0 0 510 510" style="enable-background:new 0 0 510 510;" xml:space="preserve"><g><g id="add-circle"><path class="add-circle-green" d="M255,0C114.75,0,0,114.75,0,255s114.75,255,255,255s255-114.75,255-255S395.25,0,255,0z M382.5,280.5h-102v102h-51v-102    h-102v-51h102v-102h51v102h102V280.5z" fill="#FFFFFF"/></g></g></svg>';

        addImage.addEventListener('click', () => { this.fps.openFileUpload(); });
        elems.appendChild(addImage);

        callback(elems);

    }

    manufacturerSave( id ) {

        let data = { type: ModuleType.MANUFACTURERS, data: '{"manufacturer":"' + this.currentManufacturer + '"}' };

        this.saveRequest(id, data);

    }

    newsSave( id ) {

        let data = { type: ModuleType.NEWS, data: '' };

        this.saveRequest(id, data);

    }

    slideshowSave( id ) {

        let data = { type: ModuleType.SLIDESHOW, data: JSON.stringify({ images: this.fps.getSaveJson() }) };

        this.saveRequest(id, data);

    }

    saveRequest( id, data ) {

        axios.post('/pages/frontpage/edit/' + id, data).then( res => {

            // Update the current working tile data!
            this.currentWorkingTile.querySelector('.frontpage-module-type').innerHTML = res.data.type;
            this.currentWorkingTile.querySelector('.frontpage-module-data').innerHTML = res.data.moduleTitle;

            this.closeModal()
            window.location.reload();


        }).catch( e => {

            swal( 'D@mn 😲', 'Couldn\'t save module, please check console for debug logs.', 'error' );
            console.error('Debug', e);

        })

    }

}
