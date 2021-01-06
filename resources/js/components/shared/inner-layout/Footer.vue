<template>
  <footer class="app_footer">
    <!-- <ul class="fter_link">
      <li>
        <a href="JavaScript:void(0);" @click="openPrivacyPolicy">Privacy Policy</a>
      </li>
    </ul> -->
    <p>
      <a href="JavaScript:void(0);" @click="openFaq">FAQ</a> | <a href="JavaScript:void(0);" @click="openPrivacyPolicy">Privacy Policy</a> | © {{currentDate.getFullYear()}}
      {{ appName }}, All rights reserved
    </p>
  </footer>
</template>

<script>
import config from "../../../config";
export default {
  data() {
    return {
      appName: "",
      currentDate: new Date,
    };
  },
  created() {
    this.appName = config.APP_NAME;
  },
  methods: {
    openPrivacyPolicy() {
      window.open(config.BASE_URL + "privacy-policy", "_blank");
    },
    openFaq() {
      window.open(config.BASE_URL + "faq", "_blank");
    },
  },
};
</script>

<style></style>
