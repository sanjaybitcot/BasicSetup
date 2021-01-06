<template>
  <div>
    <outer-headers />
    <outer-sidebar v-if="currentUrl != '/project/shopify/BasicSetup/login'" />
    <slot />
    <outer-footer v-if="currentUrl != '/project/shopify/BasicSetup/login'" />
  </div>
</template>

<script>
import config from "../../config";
import HeaderComponent from "../shared/outer-layout/Header.vue";
import SidebarComponent from "../shared/outer-layout/Sidebar.vue";
import FooterComponent from "../shared/outer-layout/Footer.vue";
export default {
  components: {
    "outer-headers": HeaderComponent,
    "outer-sidebar": SidebarComponent,
    "outer-footer": FooterComponent,
  },
  data() {
    return {
      prefix: "",
      currentUrl: ""
    };
  },
  created: function () {
    this.prefix = config.URL_PREFIX;
    this.currentUrl = window.location.pathname;
    console.log(this.prefix);
    console.log(this.currentUrl);
  },
  watch: {
    $route(to, from) {
      this.currentUrl = window.location.pathname;
    },
  },
};
</script>

<style>
</style>