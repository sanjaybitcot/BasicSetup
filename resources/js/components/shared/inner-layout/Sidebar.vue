<template>
  <aside class="app_sidebar">
    <b-sidebar id="sidebar-border" sidebar-class="hero_sidebar">
      <div class="sidebar_logo">
        <router-link to="/dashboard">
          <b-img
            class="light_themes_logo"
            :src="assetsURL + 'app/images/icons/logo.png'"
            fluid
            alt="Hubifyapps"
          ></b-img>
          <b-img
            class="dark_themes_logo"
            :src="assetsURL + 'app/images/icons/logo-white.png'"
            fluid
            alt="Hubifyapps"
          ></b-img>
        </router-link>
      </div>
      <nav class="app_menu">
        <b-nav vertical class="nav_ele">
          <li>
            <router-link
              to="/dashboard"
              :class="[currentPage.includes('dashboard') ? activeClass : '']"
            >
              <i class="fa fa-th-large" aria-hidden="true"></i>
              <span class="app_menu_label">Dashboard</span>
            </router-link>
          </li>
          <li>
            <router-link
              to="/theme-integration"
              :class="[currentPage.includes('theme-integration') ? activeClass : '']"
            >
              <i class="fa fa-bars" aria-hidden="true"></i>
              <span class="app_menu_label">Theme Integration</span>
            </router-link>
          </li>
          <li>
            <router-link to data-toggle="collapse" data-target="#submenu-2">
              <i class="fa fa-cog" aria-hidden="true"></i>
              <span class="app_menu_label">Settings</span>
              <i class="submenu_fa fa fa-angle-down pull-right"></i>
            </router-link>
            <ul id="submenu-2" class="collapse submenu_item">
              <li>
                <router-link
                  to="/settings/theme"
                  :class="[currentPage.includes('theme') ? activeClass : '']"
                  >Admin Theme</router-link
                >
              </li>
              <li>
                <router-link
                  to="/settings/account"
                  :class="[currentPage.includes('account') ? activeClass : '']"
                  >Account</router-link
                >
              </li>
            </ul>
          </li>

          <li>
            <router-link
              to="/contact-support"
              :class="[currentPage.includes('contact-support') ? activeClass : '']"
            >
              <i class="fa fa-phone" aria-hidden="true"></i>
              <span class="app_menu_label">Contact Support</span>
            </router-link>
          </li>
        </b-nav>
      </nav>
    </b-sidebar>
  </aside>
</template>
<script>
import config from "../../../config";
export default {
  data() {
    return {
      setupWidgetsList: [],
      assetsURL: "",
      activeClass: "active",
    };
  },
  created() {
    this.assetsURL = config.ASSET_URL_PREFIX;
    this.getSidebarList();
  },
  computed: {
    currentPage() {
      return this.$route.path;
    },
  },
  methods: {
    getSidebarList() {
      this.$store
        .dispatch("getWidgetsPageList")
        .then((res) => {
          console.log(res);
          if (res.status === true) {
            this.setupWidgetsList = res.data;
          }
        })
        .catch((e) => console.log(e));
    },
  },
};
</script>
<style></style>
