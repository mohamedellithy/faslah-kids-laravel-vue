<template>
    <base-header class="pb-6 pb-8 pt-5 pt-md-8 bg-gradient-success">
      <!-- Card stats -->
      <b-row>
        <b-col xl="3" md="6">
          <stats-card :title="`${this.$store.state.statics.statics_1.title}`"
                      type="gradient-red"
                      :sub-title="`${this.$store.state.statics.statics_1.count}`"
                      :icon="`${this.$store.state.statics.statics_1.icon}`"
                      class="mb-4">

            <template slot="footer">
              <span class="text-nowrap">{{ this.$store.state.statics.statics_1.title }}</span>
            </template>
          </stats-card>
        </b-col>
        <b-col xl="3" md="6">
          <stats-card :title="`${this.$store.state.statics.statics_2.title}`"
                      type="gradient-orange"
                      :sub-title="`${this.$store.state.statics.statics_2.count}`"
                      :icon="`${this.$store.state.statics.statics_2.icon}`"
                      class="mb-4">

            <template slot="footer">
              <span class="text-nowrap">{{ this.$store.state.statics.statics_2.title }}</span>
            </template>
          </stats-card>
        </b-col>
        <b-col xl="3" md="6">
          <stats-card :title="`${this.$store.state.statics.statics_3.title}`"
                      type="gradient-green"
                      :sub-title="`${this.$store.state.statics.statics_3.count}`"
                      :icon="`${this.$store.state.statics.statics_3.icon}`"
                      class="mb-4">

                    <template slot="footer">
                        <span class="text-nowrap">{{ this.$store.state.statics.statics_3.title }}</span>
                    </template>
          </stats-card>

        </b-col>
        <b-col xl="3" md="6">
            <stats-card :title="`${this.$store.state.statics.statics_4.title}`"
                      type="gradient-info"
                      :sub-title="`${this.$store.state.statics.statics_4.count}`"
                      :icon="`${this.$store.state.statics.statics_4.icon}`"
                      class="mb-4">

                    <template slot="footer">
                        <span class="text-nowrap">{{ this.$store.state.statics.statics_4.title }}</span>
                    </template>
            </stats-card>
        </b-col>
      </b-row>
    </base-header>
</template>
<script>
export default {
    name:'statics-row'

}
</script>
