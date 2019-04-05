Vue.component('question-radio', {
    props: ['title','reminder','options','value','id'],
    template:  '<div :id="id" class="question-block type-radio" :class="{error: this.$parent.errors[this.id]}">\
                    <div class="header">\
                        <span class="title" v-html="title"></span> <span class="reminderText" v-if="reminder">({{reminder}})</span>\
                    </div>\
                    <div class="answers">\
                        <template v-for="(option, index) in options">\
                            <input type="radio" :id="id+\'-\'+index" v-model="internalValue" :value="option.value" :name="id" @change="emitValue">\
                            <label :for="id+\'-\'+index" v-html="option.label" :class="{selected: internalValue==option.value}"></label>\
                        </template>\
                    </div>\
                    <div class="error-message">{{this.$parent.errors[this.id]}}</div>\
                </div>',
    data: function () {
        return { internalValue: null}
    },
    methods: {
        emitValue: function () {
            this.$emit('input', this.internalValue)
        }
    },
    watch: {
        value: function (newVal, oldVal) {
            if(newVal !== oldVal)
                this.internalValue = newVal;
        }
    },
    created: function () {
        this.internalValue = this.value;
    }
});

Vue.component('question-checkbox', {
    props: ['title','value','id'],
    template:  '<div :id="id" class="question-block type-radio type-checkbox" :class="{error: this.$parent.errors[this.id]}">\
                    <input type="checkbox" :id="id+\'input\'" :name="id" v-model="internalValue" @change="emitValue" true-value="1" false-value="0">\
                    <label :for="id+\'input\'" v-html="title" :class="{selected: internalValue==1}">Okay</label>\
                    <div class="error-message">{{this.$parent.errors[this.id]}}</div>\
                </div>',
    data: function () {
        return { internalValue: null}
    },
    methods: {
        emitValue: function () {
            this.$emit('input', this.internalValue)
        }
    },
    watch: {
        value: function (newVal, oldVal) {
            if(newVal !== oldVal)
                this.internalValue = newVal;
        }
    },
    created: function () {
        this.internalValue = this.value;
    }
});

Vue.component('question-checkbox-only', {
    props: ['value','id'],
    template:  '<div :id="id" class="type-checkbox-only" :class="{error: this.$parent.errors[this.id]}">\
                    <input type="checkbox" :id="id+\'input\'" :name="id" v-model="internalValue" @change="emitValue" true-value="1" false-value="0">\
                    <div class="error-message">{{this.$parent.errors[this.id]}}</div>\
                </div>',
    data: function () {
        return { internalValue: null}
    },
    methods: {
        emitValue: function () {
            this.$emit('input', this.internalValue)
        }
    },
    watch: {
        value: function (newVal, oldVal) {
            if(newVal !== oldVal)
                this.internalValue = newVal;
        }
    },
    created: function () {
        this.internalValue = this.value;
    }
});

Vue.component('question-select', {
    props: ['title','reminder','options','value','id'],
    template:  '<div :id="id" class="question-block type-select" :class="{error: this.$parent.errors[this.id]}">\
                    <div class="header">\
                        <span class="title" v-html="title"></span> <span class="reminderText" v-if="reminder">({{reminder}})</span>\
                    </div>\
                    <div class="answers">\
                        <select v-model="internalValue" class="form-control" @change="emitValue">\
                            <option value=""></option>\
                            <option v-for="option in options" :value="option.value">{{option.label}}</option>\
                            <span class="error-message">{{this.$parent.errors[this.id]}}</span>\
                        </select>\
                    </div>\
                </div>',
    data: function () {
        return { internalValue: null}
    },
    methods: {
        emitValue: function () {
            this.$emit('input', this.internalValue)
        }
    },
    watch: {
        value: function (newVal, oldVal) {
            if(newVal !== oldVal)
                this.internalValue = newVal;
        }
    },
    created: function () {
        this.internalValue = this.value;
    }
});

Vue.component('question-combobox', {
    props: ['title','reminder','options','value','id'],
    template:  '<div :id="id" class="question-block type-combobox" :class="{error: this.$parent.errors[this.id]}">\
                    <div class="header">\
                        <span class="title" v-html="title"></span> <span class="reminderText" v-if="reminder">({{reminder}})</span>\
                    </div>\
                    <div class="answers">\
                        <v-select v-model="internalObject" :options="options" @change="emitValue"></v-select>\
                        <span class="error-message">{{this.$parent.errors[this.id]}}</span>\
                    </div>\
                </div>',
    methods: {
        emitValue: function () {
            if(this.internalObject == null)
                this.$emit('input', null);
            else
                this.$emit('input', this.internalObject.value);
        },
        matchExternalValue: function() {
            for(let i=0; i<this.options.length; i++) {
                if(this.options[i].value === this.value) {
                    this.internalObject = this.options[i];
                    break;
                }
            }
        }
    },
    data: function () {
        return { internalObject: null}
    },
    watch: {
        value: function (newVal, oldVal) {
            if(newVal !== oldVal)
                this.matchExternalValue();
        }
    },
    created: function () {
        this.matchExternalValue();
    }
});

Vue.component('question-text', {
    props: ['title','reminder','value','id'],
    template:  '<div :id="id" class="question-block type-text" :class="{error: this.$parent.errors[this.id]}">\
                    <div class="header" v-show="title">\
                        <span class="title" v-html="title"></span> <span class="reminderText" v-if="reminder">({{reminder}})</span>\
                    </div>\
                    <div class="answers">\
                        <input type="text" :value="value" @input="setValue">\
                    </div>\
                    <span class="error-message">{{this.$parent.errors[this.id]}}</span>\
                </div>',
    methods: {
        setValue: function (event) {
            this.$emit('input', event.target.value);
        }
    }
});