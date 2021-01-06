domainPath="https://localhost/ai-recommendations/";
  var ai_cart = [];

            if (localStorage.ai_cart)
            {
                ai_cart = JSON.parse(localStorage.ai_cart);
              
            }

  if(!Shopify.shop){
   var shopurl=ai_shop; 
  }else{
  var shopurl=Shopify.shop;  
  }
 if(Shopify.checkout)
 {  
  var orderInfo=Shopify.checkout;
  //ai_cart = JSON.parse(localStorage.ai_cart);

var xhttp = new XMLHttpRequest();
xhttp.open("POST", "http://127.0.0.1:8000/api/storeOrder", true);
xhttp.onreadystatechange = function() {
   if (this.readyState == 4 && this.status == 200) {
     // Response
     var response = this.responseText;
           if(response == 1){
            
            localStorage.clear();
           }
   }
};
var data = {orderInfo:orderInfo,ai_cart: ai_cart,shop: shopurl};
xhttp.send(JSON.stringify(data));
 }else
 {
 


 var shopStatus = $.parseJSON($.ajax({
        url:  domainPath+'api/appActivation?shop='+shopurl,
        dataType: "json", 
        async: false
    }).responseText);

if(shopStatus.data.store_status == 1)
{        var ai_page_id=0; 
        var store_id=shopStatus.data.store_id;
      if(ai_template =="product" || ai_template =="cart")
      {
        var widgetList = {product:1,cart:4};
        var ai_page_id=widgetList[ai_template];
        var slidecontent="<div class='eran_hero' style='width:100%; margin:0 auto;max-width:1170px;'> <div class='related_title'> <h3>Product Recommendation</h3> </div> <div class='owl-carousel owl-theme earning_grid_slider' id='earningProduct'><img src='"+domainPath+"public/front_end/image/loaderNew.gif'></div> </div>";
        $("main, .main-content, #MainContent").append(slidecontent);

         var frontendStatus = $.parseJSON($.ajax({
              url:  domainPath+'api/getProductList?store_url='+shopurl+'&ai_template='+ai_template+'&product_id='+ai_product_id,
              dataType: "json", 
              async: false
          }).responseText);
          
      document.getElementById("earningProduct").innerHTML=frontendStatus.data.product_list;
    
   
        function addCSS(t) {
            var e = document.getElementsByTagName("head")[0],
                i = document.createElement("link");
            i.href = t, i.type = "text/css", i.rel = "stylesheet", e.append(i)
        }
        addCSS(domainPath + "public/front_end/css/earning_recommand_style.css");
        addCSS("//cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css");
        addCSS("//dev.ingrub.com/psl/owlcarousel/assets/owl.theme.default.min.css");
        AddJS("//cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js");
        function AddJS(path){
            var fileref=document.createElement('script');
            fileref.setAttribute("type","text/javascript");
            fileref.setAttribute("src", path);
          document.getElementsByTagName("head")[0].appendChild(fileref);
        }


       $(function() { 
        /* add to cart click*/
          $('body').on("click", ".earningbtn", function() { 

             var selectedvrnt=$(this).parents(".earning_item").find(".earning_variant_id");
             var shopify_product_id=$(this).parents(".earning_item").attr("shopify_product_id");
            selectedvriant = selectedvrnt.children("option:selected").val();
            var ai_product_id=$(this).parents(".earning_item").attr("id");
                var prd_id=ai_product_id.split('product_');
                  product_id_db=prd_id['1'];
               var ai_widget_type_data=$(this).parents(".earning_item").find('a').attr("widget-type-data");
            addItemToCartEarning(selectedvriant,1,ai_product_id,ai_page_id,ai_widget_type_data,product_id_db,shopify_product_id);
         
          });
         /* box click*/
          $('body').on("click", ".earning_item", function() { 
             var selectedvrnt=$(this).find(".earning_variant_id");
             var ai_product_id=$(this).attr("id");
             var prd_id=ai_product_id.split('product_');
             product_id_db=prd_id['1'];
             var ai_widget_type_data=$(this).find('a').attr("widget-type-data");
            itemclickCount(ai_product_id,ai_page_id,ai_widget_type_data,product_id_db);
         
          });

             $('body').on("change", ".earning_variant_id", function() { 
              var selectedvrnt=$(this).parents(".earning_item").find(".earning_variant_id");
              variant_quantity = selectedvrnt.children("option:selected").attr("quantity-data");
              var earningbtn=$(this).parents(".earning_item").find(".earningbtn");
              if(variant_quantity == 0){
                 $(earningbtn).text("Out Of Stock").prop("disabled", true);
              }else{
                 $(earningbtn).text("Add To Cart").prop("disabled", false);
              }

          });
      });


      /*http://www.codeshopify.com/blog_posts/adding-to-cart-with-ajax */
       function addItemToCartEarning(variant_id, qty,ai_product_id,ai_page_id,ai_widget_type_data,product_id_db,shopify_product_id) {
                 var  earningbtnlodr=$("#"+ai_product_id).find(".earningbtn");
     
       data = {
            "id": variant_id,
            "quantity": qty,
          }
         
          /*add to cart shopify*/
     jQuery.ajax({
            type: 'POST',
            url: '/cart/add.js',
            data: data,
            dataType: 'json',
                beforeSend: function() {
                      $(earningbtnlodr).text("Loading...").prop("disabled", !0);
                  },
            success: function() { 
              $(earningbtnlodr).text("Add To Cart").prop("disabled", 0);
              window.location.href = '/cart'; 
            }
          });

           /*updateCountAddToCart on database*/
           jQuery.ajax({
            type: 'POST',
            url: domainPath+'api/updateCountAddToCart',
            data: {"store_id":store_id,"widgets_page_id":ai_widget_type_data,"widgets_id":ai_widget_type_data,"product_id":product_id_db},
            success: function(data) {
              console.log(data); 
             
            }
          });

              /*for add to cart in cookies*/

                for (var i in ai_cart) {
                      if(ai_cart[i].VariantId == variant_id)
                      {
                          ai_cart[i].aiWidgetTypeData = ai_widget_type_data;
                          aiSaveCart();
                          return;
                      }
                  }

                  // create JavaScript Object
                  var item = { productId: shopify_product_id, VariantId: variant_id, aiPageId: ai_page_id, aiWidgetTypeData:ai_widget_type_data }; 
                  ai_cart.push(item);
                         aiSaveCart();
     
                 /* add to cart cookies */ 
          
        }

         function itemclickCount(ai_product_id,ai_page_id,ai_widget_type_data,product_id_db) {
              
           /*updateCountAddToCart on database*/
             jQuery.ajax({
            type: 'POST',
            url: domainPath+'api/updateCountProductClick',
            data: {"store_id":store_id,"widgets_page_id":ai_widget_type_data,"widgets_id":ai_widget_type_data,"product_id":product_id_db},
            success: function(data) {
              console.log(data); 
            }
          });
          
        }

 
        function aiSaveCart() {
                  if ( window.localStorage)
                  {
                      localStorage.ai_cart = JSON.stringify(ai_cart);
                  }
              }

        $(function() { 
          var owl = $('.owl-carousel');
          owl.owlCarousel({
            autoplay: false,
            loop: true,
            margin: 10,
            responsiveClass: true,
            autoHeight: true,
            autoplayTimeout: 7000,
            smartSpeed: 800,
            nav: true,
            dots: false,
            responsive: {
              0: {
                items: 1
              },
              600: {
                items: 2
              },
              1000: {
                items: 4
              }
            }
          });
       owl.trigger('refresh.owl.carousel');

        });

    }     
  }
} 