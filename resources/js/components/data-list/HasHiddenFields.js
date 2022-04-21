export default {

    computed: {

        hiddenFields() {
            return this.$store.state.publish[this.publishContainer].hiddenFields;
        },

        visibleValues() {
            let hiddenFields = _.chain(this.hiddenFields)
                .pick(field => field.hidden && field.omitValue)
                .keys()
                .value();

            return new HiddenValuesOmitter(this.values, this.jsonSubmittingFields).omit(hiddenFields);
        },

    }

}
