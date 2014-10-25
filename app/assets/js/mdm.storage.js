
DStorage = Kelas({
    data: undefined,
    initialize: function(name) {
        this.name = name;
    },
    set: function(key, value) {
        var data = this.all();
        data = data || {};
        data[key] = value;
        this.save(data);
    },
    unset: function(key) {
        var data = this.all();
        if (data) {
            data[key] = undefined;
            this.save(data);
        }
    },
    get: function(key) {
        var data = this.all();
        return data[key];
    },
    first: function() {
        var data = this.all();
        for (var datum in data) {
            if (datum !== undefined) {
                return datum;
            }
        }
        return false;
    },
    all: function() {
        if (this.data === undefined || this._expire()) {
            this.data = this._get();
        }
        return this.data;
    },
    save: function(data) {
        this.data = data;
        this._save();
    },
    delete: function() {
        this._delete();
        this.data = undefined;
    },
    // internal function
    _expire: function() {
        return false;
    },
    _get: function() {
        return undefined;
    },
    _save: function() {

    },
    _delete: function() {

    }
});

DLocalStorage = Kelas(DStorage, {
    _local: {},
    initialize: function(name) {
        this._local = {
            name: 'mdm-key-' + name,
            key: 'mdm-flug-' + name,
            time: undefined,
        };
        DStorage.initialize.call(this, name);
    },
    _get: function() {
        var s = localStorage.getItem(this._local.name);
        this._local.time = (new Date()).getTime();
        return s ? JSON.parse(s) : undefined;
    },
    _save: function() {
        localStorage.setItem(this._local.name, JSON.stringify(this.data));
        this._local.time = (new Date()).getTime();
        localStorage.setItem(this._local.key, this._local.time);
    },
    _delete: function() {
        localStorage.removeItem(this._local.name);
        this._local.time = (new Date()).getTime();
        localStorage.removeItem(this._local.key);
    },
    _expire: function() {
        var s = localStorage.getItem(this._local.key);
        return this._local.time == undefined || (s != undefined && s * 1 > this._local.time);
    }
});
