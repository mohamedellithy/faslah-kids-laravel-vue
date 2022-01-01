<template>
    <div>
        <!-- SOURCE -->
        <div id="printMe">
            <span v-for="index  in parseInt(count_copies)"  :key="index">
                <span class="qrcode-logo" v-html="qrcodes.image"></span>
            </span>
        </div>
    </div>
</template>
<script>
export default{
    name:'qrcode-print',
    data () {
        return {
            output: null,
            count_copies:1,
            qrcodes:{},
        }
    },
    props: {
    },
    methods: {
        async print () {
            // Pass the element id here
            await this.$htmlToPaper('printMe');
        }
    },
    created:function(){
        let self = this;
        Event.$on("ContentPrint",function(printedData){
            self.count_copies = printedData.count_copies;
            self.qrcodes      = printedData.qrcodes;
            console.log(printedData);
        });
    },
}
</script>
