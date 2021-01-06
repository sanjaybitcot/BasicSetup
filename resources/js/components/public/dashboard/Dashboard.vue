<template>
  <div>
    <main class="app-content">
      <title-mob />
      <section class="dashboard">
        <b-row v-if="!isLoaderScreen">
          <b-col xl="8">
            <b-row v-if="status_front === 0">
              <b-col lg="12">
                <aside class="alert_box">
                  <b-alert variant="danger" show
                    ><b>Product Recommendation Feature Is Disable Now!</b> If you want
                    to activate the product recommendation feature on the storefront,
                    please
                    <router-link to="/theme-integration">Click here</router-link></b-alert
                  >
                </aside>
              </b-col>
            </b-row>
            <div class="hero_abt">
              <b-card class="card_panel">
                <b-row>
                  <b-col lg="6" class="hero_abt_col">
                    <div class="hero_abt_info">
                      <div class="hero_abt_title">
                        <h4 class="h4_title">
                          Step to Get Started with
                          {{ appNAME }}
                        </h4>
                      </div>
                      <b-list-group class="list_cst hero_list">
                        <b-list-group-item
                          >- Choose "Setup Widgets" from left menu</b-list-group-item
                        >
                        <b-list-group-item
                          >- Assign widgets on the required pages</b-list-group-item
                        >
                        <b-list-group-item>
                          - Edit widget settings to set & customize it.
                          <br />Check and review this action on your live store.
                          <span class="abt_icn"></span>
                        </b-list-group-item>
                      </b-list-group>
                    </div>
                  </b-col>
                  <b-col lg="6" class="hero_abt_col">
                     <div class="abt_vidoes">
                    <iframe
                      width="100%"
                      height="315"
                      src="https://www.youtube.com/embed/9H5UeGD3AVc"
                      frameborder="0"
                      allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                      allowfullscreen
                    ></iframe>
                         </div>
                  </b-col>
                </b-row>
              </b-card>
            </div>
          </b-col>
          <b-col xl="4">
            <div class="hero_ele">
              <b-card no-body class="card_panel">
                <article class="faq_info">
                  <div class="hero_ele_title">
                    <h4 class="h4_title">FAQ</h4>
                  </div>
                  <div class="accordion" role="tablist">
                    <b-card no-body class="faqs_items">
                      <b-card-header header-tag="header" role="tab">
                        <div block v-b-toggle.accordfaq-1>
                          <h6 class="h6_title">
                            Where we can set product recommendations widgets?
                          </h6>
                        </div>
                      </b-card-header>
                      <b-collapse
                        id="accordfaq-1"
                        accordion="my-accordion"
                        role="tabpanel"
                      >
                        <b-card-body>
                          <b-card-text
                            >You can set up widgets on the product page and cart page.
                            Widget will appear below of the product and cart
                            pages</b-card-text
                          >
                          <!-- <b-card-text
                            >Click <b-link>Here</b-link> to see the pricing structure
                            according to your store plan.</b-card-text
                          > -->
                        </b-card-body>
                      </b-collapse>
                    </b-card>
                    <b-card no-body class="faqs_items">
                      <b-card-header header-tag="header" role="tab">
                        <div block v-b-toggle.accordfaq-2>
                          <h6 class="h6_title">How do manual recommendations work?</h6>
                        </div>
                      </b-card-header>
                      <b-collapse
                        id="accordfaq-2"
                        accordion="my-accordion"
                        role="tabpanel"
                      >
                        <b-card-body>
                          <b-card-text
                            >Just go to the Manual Recommendations section on the
                            dashboard, select main product and then select recommended
                            product which you want to display as a
                            recommendation.</b-card-text
                          >
                          <!-- <b-card-text
                            >Go to Shopify admin >> Settings >> Plans & Permissions >> Add
                            staff account >> Enter the required details >> Send
                            invite.</b-card-text
                          >
                          <b-card-text
                            >We can also send you a collaborator access request if you
                            have limited staff member account in your store
                            plan.</b-card-text
                          > -->
                        </b-card-body>
                      </b-collapse>
                    </b-card>
                    <b-card no-body class="faqs_items">
                      <b-card-header header-tag="header" role="tab">
                        <div block v-b-toggle.accordfaq-3>
                          <h6 class="h6_title">
                            Can I configure the app to show only products from the same
                            collection?
                          </h6>
                        </div>
                      </b-card-header>
                      <b-collapse
                        id="accordfaq-3"
                        accordion="my-accordion"
                        role="tabpanel"
                      >
                        <b-card-body>
                          <b-card-text
                            >Yes, you can configure recommended products based on
                            different conditions like same collection, same vendor, same
                            tages and type. Go to dashboard--> Automatic Recommendation-->
                            Setting Icon and select preference.</b-card-text
                          >
                        </b-card-body>
                      </b-collapse>
                    </b-card>
                    <!-- <b-card no-body class="acdion_faq">
                      <b-card-header header-tag="header" role="tab">
                        <b-button class="acdion_faq_title" block v-b-toggle.accordion-1
                          >Is the App Free?</b-button
                        >
                      </b-card-header>
                      <b-collapse
                        id="accordion-1"
                        accordion="my-accordion"
                        role="tabpanel"
                      >
                        <b-card-body>
                          The app is Free until it generates $50 sales for your store in a
                          given month. After that, the fee will be as per the pricing
                          plans mentioned here.
                        </b-card-body>
                      </b-collapse>
                    </b-card>
                    <b-card no-body class="acdion_faq">
                      <b-card-header header-tag="header" role="tab">
                        <b-button class="acdion_faq_title" block v-b-toggle.accordion-2
                          >Which orders do you consider as {{ appNAME }} generated
                          sales?</b-button
                        >
                      </b-card-header>
                      <b-collapse
                        id="accordion-2"
                        accordion="my-accordion"
                        role="tabpanel"
                      >
                        <b-card-body>
                          All the orders which were created by clicking on the products
                          shown in {{ appNAME }} widgets are considered as
                          {{ appNAME }} generated sales.
                        </b-card-body>
                      </b-collapse>
                    </b-card>
                    <b-card no-body class="acdion_faq">
                      <b-card-header header-tag="header" role="tab">
                        <b-button class="acdion_faq_title" block v-b-toggle.accordion-3
                          >How do we customize the look of
                          {{ appNAME }} widgets?</b-button
                        >
                      </b-card-header>
                      <b-collapse
                        id="accordion-3"
                        accordion="my-accordion"
                        role="tabpanel"
                      >
                        <b-card-body>
                          All the orders which were created by clicking on the products
                          shown in {{ appNAME }} widgets are considered as
                          {{ appNAME }} generated sales.
                        </b-card-body>
                      </b-collapse>
                    </b-card> -->
                  </div>
                  <div class="view_more">
                    <router-link class="action_link" to="/faq">View More</router-link>
                  </div>
                </article>
                <article class="support_info">
                  <div class="hero_ele_title">
                    <h4 class="h4_title">Help &amp; Support</h4>
                  </div>
                  <b-nav vertical>
                    <!-- <b-nav-item class="nav-link_cst">
                      <span>
                        <i class="fa fa-commenting-o" aria-hidden="true"></i>
                      </span>Live Chat
                    </b-nav-item>-->
                    <b-nav-item class="nav-link_cst">
                      <span> <i class="fa fa-envelope-o" aria-hidden="true"></i> </span
                      >support@hubifyapps.com
                    </b-nav-item>
                  </b-nav>
                </article>
                <article class="latest_update d-none">
                  <div class="hero_ele_title">
                    <h4 class="h4_title">Latest Updates</h4>
                  </div>
                  <ul class="update_info">
                    <div class="update_line"></div>
                    <li>
                      <span class="update_date">April 13</span>
                      <p>
                        Integrated with
                        <a href="#" target="_blank">ReConvert</a>. Display recommendations
                        on thank you page.
                      </p>
                    </li>
                    <li>
                      <span class="update_date">March 12</span>
                      <p>
                        Launched a new widget
                        <a href="#">Inspired by your browser history</a>.
                      </p>
                    </li>
                    <span id="more">
                      <li>
                        <span class="update_date">Jan 17</span>
                        <p>Integrated with Judge.me Review App.</p>
                        <p>Show reviews from Judge.me app in {{ appNAME }} widgets.</p>
                      </li>
                      <li>
                        <span class="update_date">Jan 13</span>
                        <p>
                          Integrated with
                          <a href="#" target="_blank">Pagefly Pagebuilder App</a>.
                        </p>
                        <p>Now use {{ appNAME }} widgets in Pagefly app too.</p>
                      </li>
                      <li>
                        <span class="update_date">Jan 11</span>
                        <p>Integrated with Alireviews Review App.</p>
                        <p>Show reviews from Alireviews app in {{ appNAME }} widgets.</p>
                      </li>
                      <li>
                        <span class="update_date">Jan 6</span>
                        <p>Launched Email Recommendations Widget.</p>
                        <p>Send product recommendations in your Email campaigns.</p>
                      </li>
                    </span>
                    <a
                      href="javascript:void();"
                      onclick="myFunction()"
                      id="myBtn"
                      class="faq_viewmore"
                      style="text-decoration: none"
                      >Read more</a
                    >
                    <span id="dots">&nbsp;</span>
                  </ul>
                </article>
              </b-card>
            </div>
          </b-col>
        </b-row>
        <div v-if="isLoaderScreen" class="pre_loader">
          <div class="spinner-border btn-spinner">
            <span class="sr-only">Loading...</span>
          </div>
        </div>
      </section>
    </main>
  </div>
</template>

<script>
import config from "../../../config";
import TitleMob from "../common/DynamicTitle.vue";
export default {
  components: {
    "title-mob": TitleMob,
  },
  data() {
    return {
      assetsURL: "",
      currentStore: "",
      dashboardDetail: [],
      isLoaderScreen: false,
      appNAME: "",
      status_front: "",
    };
  },
  mounted() {
    document.body.classList.remove("login-body");
    document.body.classList.remove("install_body");
  },
  created() {
    this.assetsURL = config.ASSET_URL_PREFIX;
    this.appNAME = config.APP_NAME;
    if (localStorage) {
      this.currentStore = JSON.parse(localStorage.getItem("currentStore"));
    }
    this.getActiveWidgetsList();
    this.getAppPublishTheme();
  },
  methods: {
    getAppPublishTheme() {
      this.isLoaderScreen = true;
      this.$store
        .dispatch("getAppPublishTheme", +this.currentStore.store_id)
        .then((res) => {
          this.isLoaderScreen = false;
          if (res.status === true) {
            this.status_front = +res.status_front;
          }
        })
        .catch((e) => {
          this.isLoaderScreen = false;
          console.log(e);
        });
    },
    getActiveWidgetsList() {
      this.isLoaderScreen = true;
      this.$store
        .dispatch("getActiveWidgetsList", +this.currentStore.store_id)
        .then((res) => {
          this.isLoaderScreen = false;
          if (res.status === true) {
            this.dashboardDetail = res.data;
          }
        })
        .catch((e) => {
          this.isLoaderScreen = false;
        });
    },
  },
};
</script>
