<template>
  <div>
    <main class="app-content">
      <title-mob />
      <section class="faqs">
        <b-row>
          <!-- <b-col xl="12">
            <div class="faqs_content">
              <b-card no-body class="card__panel">
                <b-card-header
                  ><h5 class="h5_title">General Announcements</h5></b-card-header
                >
                <b-card-body>
                  <div class="accordion general_accrdion" role="tablist">
                    <b-card no-body class="faqs_items">
                      <b-card-header header-tag="header" role="tab">
                        <div block v-b-toggle.accordGeneral-1>
                          <h6 class="h6_title">
                            How to Remove {{ appNAME }}'s Leftover Code from Theme Files?
                          </h6>
                          <p>
                            Although our app's code doesnt affect the sites but still we
                            recommend to remove it from theme files.
                          </p>
                        </div>
                      </b-card-header>
                      <b-collapse
                        id="accordGeneral-1"
                        accordion="my-accordion"
                        role="tabpanel"
                      >
                        <b-card-body>
                          <b-card-text
                            >You can remove it by following the below process:<b
                              >In your store admin, Click on Online store >> Themes >>
                              Action >> Edit Code</b
                            ></b-card-text
                          >
                          <b-card-text
                            >Here in the left sidebar search for<b>
                              Index.liquid, product.liquid, cart.liquid &
                              collection.liquid </b
                            >file</b-card-text
                          >
                          <b-card-text
                            >You need to delete<b
                              >{% include "recently-viewed-products" %}</b
                            >from these files and save the changes.
                          </b-card-text>
                          <div class="or__text">Or</div>
                          <b-card-text
                            >Search and remove below provided codes from the following
                            files<b
                              >theme.liquid, collection.liquid, product.liquid,
                              cart.liquid,</b
                            >and<b> index.liquid</b>file</b-card-text
                          >
                          <b-row>
                            <b-col xl="6">
                              <b-list-group>
                                <b-list-group-item
                                  >{% include 'wiser' %}</b-list-group-item
                                >
                                <b-list-group-item
                                  >{% include 'wiser_trending' %}</b-list-group-item
                                >
                                <b-list-group-item
                                  >{% include 'wiser_recentview' %}</b-list-group-item
                                >
                                <b-list-group-item
                                  >{% include 'wiser_newarrivals' %}</b-list-group-item
                                >
                                <b-list-group-item
                                  >{% include 'wiser_featured' %}</b-list-group-item
                                >
                                <b-list-group-item
                                  >{% include 'wiser_topselling' %}</b-list-group-item
                                >
                                <b-list-group-item
                                  >{% include 'wiser_related' %}</b-list-group-item
                                >
                                <b-list-group-item
                                  >{% include 'wiser_recommended' %}</b-list-group-item
                                >
                                <b-list-group-item
                                  >{% include 'wiser_alsobought'</b-list-group-item
                                >
                                <b-list-group-item
                                  >{% include 'wiser_recent_related' %}</b-list-group-item
                                >
                              </b-list-group>
                            </b-col>
                          </b-row>
                        </b-card-body>
                      </b-collapse>
                    </b-card>
                    <b-card no-body class="faqs_items">
                      <b-card-header header-tag="header" role="tab">
                        <div block v-b-toggle.accordGeneral-2>
                          <h6 class="h6_title">
                            Major Upgrades in {{ appNAME }} App to Give You the Best
                            Experience.
                          </h6>
                        </div>
                        <p>
                          We have done several upgrades in our app {{ appNAME }} for
                          personalized Recommendations recently, sharing the details below
                          for the same.
                        </p>
                      </b-card-header>
                      <b-collapse
                        id="accordGeneral-2"
                        accordion="my-accordion"
                        role="tabpanel"
                      >
                        <b-card-body>
                          <b-card-text
                            >This week, we have rolled out few major updates in<b
                              >{{ appNAME }} Personalized Recommendations</b
                            >
                            app for you.
                            <b
                              >Check this video for highlights and rest details are
                              below.</b
                            >
                          </b-card-text>
                          <div class="faq_vidoes">
                            <iframe
                              src="https://www.youtube.com/embed/ijUlPgY90ms?rel=0"
                              frameborder="0"
                              webkitallowfullscreen=""
                              mozallowfullscreen=""
                              allowfullscreen=""
                            ></iframe>
                          </div>
                          <hr />
                          <article class="faq_article">
                            <h6 class="h6_title">
                              All New Dashboard - more simplified & refined
                            </h6>
                            <div class="faq_img">
                              <b-img
                                fluid
                                src="app/images/thumbnails/simplified-refined.jpg"
                                alt="All New Dashboard - more simplified & refined"
                              ></b-img>
                            </div>
                            <hr />
                          </article>
                          <article class="faq_article">
                            <h6 class="h6_title">
                              Show Recommendations on Thankyou Page
                            </h6>
                            <ul class="list_faq_style">
                              <li>
                                Now you can show any product recommendations widget on the
                                Thankyou page to your customer post purchase and even on
                                blog posts as well.
                              </li>
                              <li>
                                You just have to click the Thankyou page option in left
                                panel and select the widgets you want to show there, it
                                will automatically show those widgets on Thankyou page
                                which comesup when a customer completes a purchase and see
                                order details.
                              </li>
                              <li>
                                Best widgets to show there are
                                <b
                                  >Recently viewed products, Trending products, Top
                                  Selling and You may also like.
                                </b>
                              </li>
                            </ul>
                            <hr />
                          </article>
                          <article class="faq_article">
                            <h6 class="h6_title">Frequently Bought Together Widget</h6>
                            <ul class="list_faq_style">
                              <li>
                                Frequently Bought Together system added in app which will
                                allow you to show products which were purchased together
                                most of the time by earlier customers. Your new customers
                                will be able to add all those products together to cart.
                              </li>
                              <li>
                                Frequently Bought Together actually reads your past orders
                                and calculates based on that. Then it shows the products
                                which were ordered together mostly.
                              </li>
                            </ul>
                            <div class="faq_img">
                              <b-img
                                fluid
                                src="app/images/thumbnails/frequently-bought.jpg"
                                alt="Frequently Bought Together Widget"
                              ></b-img>
                            </div>
                            <hr />
                          </article>
                          <article class="faq_article">
                            <h6 class="h6_title">Show Compare at Price</h6>
                            <b-card-text
                              >Show the compare price as well in recommendations, strike
                              through along with the usual price of product. Compare price
                              will comeup from the product details that you add in
                              admin.</b-card-text
                            >
                            <hr />
                          </article>
                          <article class="faq_article">
                            <h6 class="h6_title">Enhanced Settings Panel with Preview</h6>
                            <ul class="list_faq_style">
                              <li>
                                We have added some more settings in Customize Widgets
                                option so that you can even show variants in
                                recommendations widgets.
                              </li>
                            </ul>
                            <div class="faq_img">
                              <b-img
                                fluid
                                src="app/images/thumbnails/enhanced-settings.jpg"
                                alt="Enhanced Settings Panel with Preview"
                              ></b-img>
                            </div>
                            <hr />
                          </article>
                          <article class="faq_article">
                            <h6 class="h6_title">
                              In Depth Analytics to See Conversions by {{ appNAME }}
                            </h6>
                            <div class="faq_img">
                              <b-img
                                fluid
                                src="app/images/thumbnails/depth-analytics.jpg"
                                alt="In Depth Analytics to See Conversions"
                              ></b-img>
                            </div>
                            <b-card-text
                              >In case you havent yet tried these features, please go to
                              the app in admin of your store and try all
                              features.</b-card-text
                            >
                            <hr />
                          </article>
                        </b-card-body>
                      </b-collapse>
                    </b-card>
                    <b-card no-body class="faqs_items">
                      <b-card-header header-tag="header" role="tab">
                        <div block v-b-toggle.accordGeneral-3>
                          <h6 class="h6_title">Judge.me and {{ appNAME }} Integration</h6>
                        </div>
                        <p>
                          Show your product ratings within {{ appNAME }}'s personalized
                          product recommendations with this integration.
                        </p>
                      </b-card-header>
                      <b-collapse
                        id="accordGeneral-3"
                        accordion="my-accordion"
                        role="tabpanel"
                      >
                        <b-card-body>
                          <b-card-text
                            >With this integration, you can use functionalities of
                            {{ appNAME }} and Judge.me together to show the credibility of
                            your products to your store visitors.</b-card-text
                          >
                          <b-card-text
                            ><b>Note</b>To use the integration, you need to install both
                            the apps - Judge.me and {{ appNAME }}.
                          </b-card-text>
                          <h6 class="h6_title">About Judge.me - Product Review App</h6>
                          <b-card-text
                            >Judge.me is a Shopify app that allows merchants to receive
                            product reviews and ratings from their shoppers and display
                            these reviews on their product pages and Shopify
                            store.</b-card-text
                          >
                          <b-card-text
                            >With this, merchants can leverage user-generated content to
                            prove their credibility and quality to nudge store visitors to
                            purchase from them. Reviews are a powerful way to increase
                            your conversion and engage your shoppers in an authentic
                            manner.</b-card-text
                          >
                          <hr />
                          <article class="faq_article">
                            <h6 class="h6_title">
                              How to Integrate Judge.me and {{ appNAME }}
                            </h6>
                            <ul class="list_faq_style">
                              <li>
                                Within the {{ appNAME }} dashboard, go to 'Customize
                                Widgets'.&nbsp;
                              </li>
                              <li>
                                You will see a number of options. Select the 'Product
                                Reviews' dropdown.&nbsp;
                              </li>
                              <li>
                                Under the dropdown, toggle 'Judge.me Reviews' to enable
                                it.&nbsp;
                              </li>
                              <li>
                                You will then need to add the token to complete the
                                integration. Go to Judge.me's settings.&nbsp;
                              </li>
                              <li>
                                Click on 'Integrations and then on 'Developers'.&nbsp;
                              </li>
                              <li>
                                Copy the public token and paste it within the field on the
                                {{ appNAME }} dashboard.&nbsp;
                                <p></p>
                              </li>
                              <li>Your integration is now complete!</li>
                              <li>
                                The star rating within your product recommendations will
                                look like this:
                              </li>
                            </ul>
                            <div class="faq_img">
                              <b-img
                                fluid
                                src="app/images/thumbnails/integration_fqa.jpg"
                                alt="All New Dashboard - more simplified & refined"
                              ></b-img>
                            </div>
                          </article>
                        </b-card-body>
                      </b-collapse>
                    </b-card>
                    <b-card no-body class="faqs_items">
                      <b-card-header header-tag="header" role="tab">
                        <div block v-b-toggle.accordGeneral-4>
                          <h6 class="h6_title">PageFly and {{ appNAME }} Integration</h6>
                          <p>
                            Create new pages in minutes with PageFly and add product
                            recommendations with {{ appNAME }}
                          </p>
                        </div>
                      </b-card-header>
                      <b-collapse
                        id="accordGeneral-4"
                        accordion="my-accordion"
                        role="tabpanel"
                      >
                        <b-card-body>
                          <b-card-text
                            >With this integration you can add {{ appNAME }} product
                            recommendation widgets to pages created by PageFly - the
                            advanced page builder app.</b-card-text
                          >
                          <b-card-text
                            ><b>Note</b>To use the integration, you need to install both
                            the apps - PageFly and {{ appNAME }}.
                          </b-card-text>
                          <h6 class="h6_title">About Judge.me - Product Review App</h6>
                          <b-card-text
                            >PageFly is a powerful page builder app for Shopify stores. It
                            offers an easy-to-use drag and drop system to build a new home
                            page, product page, collection page, landing page, sales page,
                            about us page, contact us page and more.</b-card-text
                          >
                          <b-card-text
                            >The app offers 50 ready-to-use Shopify page templates along
                            with 40 design elements to help customize pages to suit brand
                            identity.</b-card-text
                          >
                          <hr />
                          <article class="faq_article">
                            <h6 class="h6_title">
                              How the PageFly and {{ appNAME }} integration works
                            </h6>
                            <b-card-text
                              >{{ appNAME }} offers a number of product recommendation
                              widgets to Shopify stores. With the PageFly integration, you
                              can add certain widgets to your new product pages and some
                              to the other.</b-card-text
                            >
                            <b-card-text
                              >We are explaining how and which ones, here.</b-card-text
                            >
                          </article>
                          <hr />
                          <article class="faq_article">
                            <h6 class="h6_title">
                              {{ appNAME }} product recommendations on product pages
                            </h6>
                            <b-card-text
                              >In the product pages, the {{ appNAME }} personalized
                              product recommendations depend on the products you choose in
                              your Page Settings modal.</b-card-text
                            >
                            <b-card-text
                              >Select the recommendations widget in the PageFly page
                              dashboard. Easily drag and drop the element in the editor to
                              preview different variations and positions. Click on the
                              element to set its parameters to suit your page
                              design.</b-card-text
                            >
                            <b-card-text
                              >Once you have dragged the recommendation widget into the
                              editor, it will pull all product recommendations of the
                              assigned product on your live page.</b-card-text
                            >
                            <b-card-text
                              ><b>Note</b>One page allows only one widget of each
                              type.</b-card-text
                            >
                            <div class="faq_img">
                              <b-img
                                fluid
                                src="app/images/thumbnails/recommendations_fqa.png"
                                alt="product recommendations on product"
                              ></b-img>
                            </div>
                            <b-card-text
                              >Recommendation widgets available for product pages created
                              on {{ appNAME }}</b-card-text
                            >
                            <ul class="list_faq_style">
                              <li>Related products</li>
                              <li>Recommended products</li>
                              <li>Also bought</li>
                            </ul>
                          </article>
                          <article class="faq_article">
                            <h6 class="h6_title">
                              {{ appNAME }} product recommendations for other pages
                            </h6>
                            <b-card-text
                              >This is if you want to add product recommendations to your
                              home page, product pages, collection pages, regular pages
                              and blog posts.</b-card-text
                            >
                            <b-card-text
                              >Select the {{ appNAME }} widget you want to display in the
                              layout. Drag and drop the element into the editor to preview
                              how it will appear on your page. Click on the element to set
                              its parameters to suit your page design.</b-card-text
                            >
                            <div class="faq_img">
                              <b-img
                                fluid
                                src="app/images/thumbnails/recommendations_fqa2.png"
                                alt="product recommendations on product"
                              ></b-img>
                            </div>
                            <b-card-text
                              ><b>Note</b>One page allows only one widget of each
                              type.</b-card-text
                            >
                            <b-card-text
                              >Once you’re done adding {{ appNAME }} product
                              recommendation widgets to the new page created on PageFly,
                              hit publish.</b-card-text
                            >
                            <b-card-text
                              >You can now see product recommendations show up on your new
                              pages.</b-card-text
                            >
                          </article>
                        </b-card-body>
                      </b-collapse>
                    </b-card>
                  </div>
                </b-card-body>
              </b-card>
            </div>
          </b-col> -->
          <b-col xl="12">
            <div class="faqs_content">
              <b-card no-body class="card__panel">
                <b-card-header><h5 class="h5_title">FAQ's</h5></b-card-header>
                <b-card-body>
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
                    <b-card no-body class="faqs_items">
                      <b-card-header header-tag="header" role="tab">
                        <div block v-b-toggle.accordfaq-4>
                          <h6 class="h6_title">
                            In which order are recommendations displayed?
                          </h6>
                        </div>
                      </b-card-header>
                      <b-collapse
                        id="accordfaq-4"
                        accordion="my-accordion"
                        role="tabpanel"
                      >
                        <b-card-body>
                          <b-card-text
                            >If you have all types of recommendations enabled, the order
                            will be the following:</b-card-text
                          >
                          <b-card-text
                            >Manual recommendations (if they are configured for the
                            current product) Automatic recommendations (selected by our
                            algorithm)
                          </b-card-text>
                          <b-card-text
                            >Please note that all types of recommendations can be enabled
                            and disabled separately and all together from the Theme
                            Integration menu, step 2.</b-card-text
                          >
                          <!-- <div class="faq_img">
                            <b-img
                              src="app/images/thumbnails/change_theme.png"
                              alt="All New Dashboard - more simplified &amp; refined"
                              fluid
                            ></b-img>
                          </div>
                          <div class="faq_img">
                            <b-img
                              src="app/images/thumbnails/change_theme2.png"
                              alt="All New Dashboard - more simplified &amp; refined"
                              fluid
                            ></b-img>
                          </div> -->
                        </b-card-body>
                      </b-collapse>
                    </b-card>
                    <b-card no-body class="faqs_items">
                      <b-card-header header-tag="header" role="tab">
                        <div block v-b-toggle.accordfaq-5>
                          <h6 class="h6_title">
                            How do you calculate the Sales Generated by {{ appNAME }}?
                          </h6>
                        </div>
                      </b-card-header>
                      <b-collapse
                        id="accordfaq-5"
                        accordion="my-accordion"
                        role="tabpanel"
                      >
                        <b-card-body>
                          <b-card-text
                            >When someone clicks on a product shown in {{ appNAME }} widgets, and add it to cart, and then purchases
                            that, then we count it as a sale made by {{ appNAME }}. Although, we don't consider your other
                            products in the order as our sale. We only count the exact
                            product which was clicked by the user.</b-card-text
                          >
                        </b-card-body>
                      </b-collapse>
                    </b-card>
                    <b-card no-body class="faqs_items">
                      <b-card-header header-tag="header" role="tab">
                        <div block v-b-toggle.accordfaq-6>
                          <h6 class="h6_title">Can I get support from you directly?</h6>
                        </div>
                      </b-card-header>
                      <b-collapse
                        id="accordfaq-6"
                        accordion="my-accordion"
                        role="tabpanel"
                      >
                        <b-card-body>
                          <b-card-text>
                            Yes, Just email us at support@hubifyapps.com and our team will
                            help you with any queries like App installation, set up to
                            match your theme, customisation, and troubleshooting any
                            issues.</b-card-text
                          >
                        </b-card-body>
                      </b-collapse>
                    </b-card>
                    <b-card no-body class="faqs_items">
                      <b-card-header header-tag="header" role="tab">
                        <div block v-b-toggle.accordfaq-7>
                          <h6 class="h6_title">
                            When installing a new theme do I need to re-install {{ appNAME }}?
                          </h6>
                        </div>
                      </b-card-header>
                      <b-collapse
                        id="accordfaq-7"
                        accordion="my-accordion"
                        role="tabpanel"
                      >
                        <b-card-body>
                          <b-card-text
                            >There's no need to reinstall the app when changing or
                            updating a theme. You need to update or adjust some settings
                            as On the dashboard go into ---> Theme integration---> Select
                            your theme. If having any issue with this, please email us at
                            support@hubifyapps.com</b-card-text
                          >
                        </b-card-body>
                      </b-collapse>
                    </b-card>
                    <!-- <b-card no-body class="faqs_items">
                      <b-card-header header-tag="header" role="tab">
                        <div block v-b-toggle.accordfaq-8>
                          <h6 class="h6_title">
                            How can I uninstall the app & remove any leftover code of your
                            app?
                          </h6>
                        </div>
                      </b-card-header>
                      <b-collapse
                        id="accordfaq-8"
                        accordion="my-accordion"
                        role="tabpanel"
                      >
                        <b-card-body>
                          <b-card-text>We are going to miss you:(</b-card-text>
                          <b-card-text
                            >To uninstall the app first you need to delete the code from
                            your files by following the below process:</b-card-text
                          >
                          <b-card-text
                            >Go to Online store >> Themes >> Action >> Edit
                            Code</b-card-text
                          >
                          <b-card-text
                            >Here in the left sidebar search for Index.liquid,
                            product.liquid, cart.liquid & collection.liquid
                            file.</b-card-text
                          >
                          <b-card-text
                            >You need to delete {% include "recently-viewed-products" %}
                            from these files and save the changes. Also, search for
                            "recently-viewed-products.liquid" snippet and delete it as
                            well.</b-card-text
                          >
                          <b-card-text
                            >Now just delete the app from your store.
                          </b-card-text>
                          <b-card-text
                            >If you are not sure, how to remove the codes, you can contact
                            us as well, we will remove it for you.</b-card-text
                          >
                        </b-card-body>
                      </b-collapse>
                    </b-card> -->
                  </div>
                </b-card-body>
              </b-card>
            </div>
          </b-col>
          <!-- <b-col xl="12">
            <div class="faqs_content">
              <b-card no-body class="card__panel">
                <b-card-header><h5 class="h5_title">How To Setup</h5></b-card-header>
                <b-card-body>
                  <div class="accordion general_accrdion" role="tablist">
                    <b-card no-body class="faqs_items">
                      <b-card-header header-tag="header" role="tab">
                        <div block v-b-toggle.accordhelp-1>
                          <h6 class="h6_title">How to setup manual recommendations?</h6>
                          <p>
                            Drafts are articles you're not ready for people to see yet
                          </p>
                        </div>
                      </b-card-header>
                      <b-collapse
                        id="accordhelp-1"
                        accordion="my-accordion"
                        role="tabpanel"
                      >
                        <b-card-body>
                          <b-card-text
                            >It's very easy to set up manual recommendations under product
                            detail page, just follow the 3 simple steps</b-card-text
                          >
                          <article class="faq_article">
                            <b-card-text>Step 1)</b-card-text>
                            <div class="faq_img">
                              <b-img
                                src="app/images/thumbnails/manual_step1.png"
                                alt="How to setup manual recommendations?"
                                fluid
                              ></b-img>
                            </div>
                            <hr />
                          </article>
                          <article class="faq_article">
                            <b-card-text>Step 2)</b-card-text>
                            <div class="faq_img">
                              <b-img
                                src="app/images/thumbnails/manual_step2.png"
                                alt="How to setup manual recommendations?"
                                fluid
                              ></b-img>
                            </div>
                            <hr />
                          </article>
                          <article class="faq_article">
                            <b-card-text>Step 3)</b-card-text>
                            <div class="faq_img">
                              <b-img
                                src="app/images/thumbnails/manual_step3.png"
                                alt="How to setup manual recommendations?"
                                fluid
                              ></b-img>
                            </div>
                            <hr />
                          </article>
                        </b-card-body>
                      </b-collapse>
                    </b-card>
                    <b-card no-body class="faqs_items">
                      <b-card-header header-tag="header" role="tab">
                        <div block v-b-toggle.accordhelp-2>
                          <h6 class="h6_title">
                            Automated Frequently Bought Together Products
                          </h6>
                        </div>
                        <p>
                          See how {{ appNAME }} shows frequently bought together products
                        </p>
                      </b-card-header>
                      <b-collapse
                        id="accordhelp-2"
                        accordion="my-accordion"
                        role="tabpanel"
                      >
                        <b-card-body>
                          <b-card-text
                            >Frequently bought together products widget in
                            {{ appNAME }} shows the products from your store, which were
                            purchased earlier by the customers together in same
                            order.</b-card-text
                          >
                          <b-card-text
                            >For this, we analyze your store orders from last 30 to 40
                            days and calculate the frequently bought together products
                            from the orders.</b-card-text
                          >
                          <b-card-text
                            >You can configure the products shown in this widget based on
                            various conditions like products which shares same collection,
                            tags, vendor or even set that manually as well.</b-card-text
                          >
                          <b-card-text
                            >Watch this video for a quick setup guide</b-card-text
                          >
                          <div class="faq_vidoes">
                            <iframe
                              src="https://www.loom.com/embed/e4bee1a6cafb47a7a40ab65015224e5d"
                              frameborder="0"
                              webkitallowfullscreen=""
                              mozallowfullscreen=""
                              allowfullscreen=""
                            ></iframe>
                          </div>
                        </b-card-body>
                      </b-collapse>
                    </b-card>
                    <b-card no-body class="faqs_items">
                      <b-card-header header-tag="header" role="tab">
                        <div block v-b-toggle.accordhelp-3>
                          <h6 class="h6_title">
                            How do I show Related Products based on product tags,
                            collections, vendor or type?
                          </h6>
                        </div>
                      </b-card-header>
                      <b-collapse
                        id="accordhelp-3"
                        accordion="my-accordion"
                        role="tabpanel"
                      >
                        <b-card-body>
                          <b-card-text
                            >Go to the app in admin, click on Related Products in left
                            panel and there you will find the option to update the
                            selection criteria for Related Products.</b-card-text
                          >
                          <div class="faq_img">
                            <b-img
                              fluid
                              src="app/images/thumbnails/product-collections.png"
                              alt="Product Collections"
                            ></b-img>
                          </div>
                        </b-card-body>
                      </b-collapse>
                    </b-card>
                    <b-card no-body class="faqs_items">
                      <b-card-header header-tag="header" role="tab">
                        <div block v-b-toggle.accordhelp-4>
                          <h6 class="h6_title">
                            What is the difference between Top Selling & Trending
                            Products?
                          </h6>
                        </div>
                      </b-card-header>
                      <b-collapse
                        id="accordhelp-4"
                        accordion="my-accordion"
                        role="tabpanel"
                      >
                        <b-card-body>
                          <b-card-text
                            >The products which were sold most comes under top selling, In
                            this we compare product sales from the other products sales in
                            last 2 weeks.
                          </b-card-text>
                          <b-card-text
                            >The products which has a growth in their own sales from last
                            2 weeks comes under trending products, In this we compare a
                            product's sales from its own sale of last 2
                            weeks.</b-card-text
                          >
                        </b-card-body>
                      </b-collapse>
                    </b-card>
                    <b-card no-body class="faqs_items">
                      <b-card-header header-tag="header" role="tab">
                        <div block v-b-toggle.accordhelp-5>
                          <h6 class="h6_title">
                            How to hide products from the wiser app widgets?
                          </h6>
                        </div>
                      </b-card-header>
                      <b-collapse
                        id="accordhelp-5"
                        accordion="my-accordion"
                        role="tabpanel"
                      >
                        <b-card-body>
                          <b-card-text
                            >To hide the specific products from the widgets, please follow
                            these steps:"
                          </b-card-text>
                          <b-card-text
                            >Go to {{ appNAME }} app dashboard and click on "Exclude
                            Products" tab from left panel. Please enter the product name
                            which you want to hide and click on the "Add Product"
                            button."</b-card-text
                          >
                          <b-card-text
                            ><b>Please note:</b> When you hide a product it will hide for
                            all the widgets by {{ appNAME }} except "Recently
                            Viewed".</b-card-text
                          >
                          <div class="faq_img">
                            <b-img
                              fluid
                              src="app/images/thumbnails/widgets-expect.png"
                              alt="Product Collections"
                            ></b-img>
                          </div>
                        </b-card-body>
                      </b-collapse>
                    </b-card>
                  </div>
                </b-card-body>
              </b-card>
            </div>
          </b-col> -->
        </b-row>
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
      appNAME: "",
    };
  },
  created() {
    this.assetsURL = config.ASSET_URL_PREFIX;
    this.appNAME = config.APP_NAME;
  },
};
</script>
