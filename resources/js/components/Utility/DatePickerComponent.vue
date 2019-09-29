<template>
   <input type="text" :value="value" v-on:input="$emit('input', $event.target.value)"/>
</template>

<script>
   export default {
      props: ['value'],
      mounted () {
         var vm = this;
         $(this.$el).datepicker({
            dateFormat: "yy-mm-dd"
         })
         .on('change', ($event) => {
            // console.log($event);
            let dateEntered = new Date($event.target.value);
            console.log(dateEntered);
            vm.$emit('input', $event.target.value);
         });
      },
      beforeDestroy() {
         $(this.$el).datepicker('hide').datepicker('destroy');
      },
   }
</script>