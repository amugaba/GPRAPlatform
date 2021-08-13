/**
 * QuestionComponents
 * Defines Vue components that can be used as input items on assessments
 * These components encapsulate the HTML and JS functionality like 2-way data binding and error messages.
 * 2-way data binding is handled via emitting an event to the parent Vue object when the selected answer changes and
 * also by watching/listening for when the value of "value" property changes.
 */

/**
 * Radio button component
 * @param title Question text
 * @param reminder Optional reminder text after title
 * @param options Option set (i.e. list of answer options to choose from)
 * @param value Answer currently selected. This should be bound using v-model attribute
 * @param id Code name of question. Used for error message display
 */
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

/**
 * Checkbox component
 */
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

/**
 * Checkbox without any title. It displays the box only
 */
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

/**
 * Dropdown select component
 */
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

/**
 * Dropdown select but also with the ability to type in the box to search
 */
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

/**
 * Text box component
 */
Vue.component('question-text', {
    props: ['title','reminder','value','id'],
    template:  '<div :id="id" class="question-block type-text" :class="{error: this.$parent.errors[this.id]}">\
                    <div class="header" v-show="title">\
                        <span class="title" v-html="title"></span> <span class="reminderText" v-if="reminder">({{reminder}})</span>\
                    </div>\
                    <div class="answers">\
                        <input type="text" :value="value" @input="setValue" maxlength="255">\
                    </div>\
                    <span class="error-message">{{this.$parent.errors[this.id]}}</span>\
                </div>',
    methods: {
        setValue: function (event) {
            this.$emit('input', event.target.value);
        }
    }
});