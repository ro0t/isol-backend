let classie = require('desandro-classie');

class NavisionSync {
    activate() {
        this.syncer = document.getElementById('productSync');
        if( this.syncer ) {
            this.syncButton = this.syncer.querySelector('button');

            this.syncButton.addEventListener('click', () => {
                this.runSync();
            });
        }
    }

    runSync() {
        classie.add(this.syncer, 'syncing');

        axios.post('/settings/dynamics-nav', null, {
            timeout: 25*60*1000 // 25 minutes
        }).then(res => {
            classie.remove(this.syncer, 'syncing');
            classie.add(this.syncer, 'finished');

            let elem = document.getElementById('sync-finished');
            if(elem) { elem.innerText = res.data; }
        }).catch(e => {
            classie.remove(this.syncer, 'syncing');
            alert('Finished with errors.');
            console.error(e);
        });

    }
}

module.exports = new NavisionSync();