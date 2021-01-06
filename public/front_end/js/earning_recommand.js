  domainPath="http://localhost/project/shopify/BasicSetup";
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
    xhttp.open("POST", domainPath+"/api/storeOrder", true);
    xhttp.onreadystatechange = function()
    {
      if (this.readyState == 4 && this.status == 200) 
      {
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
      url:  domainPath+'/api/appActivation?shop='+shopurl,
      dataType: "json", 
    async: false
    }).responseText);

    if(shopStatus.data.store_status == 1)
    {
      var ai_page_id=0; 
      var store_id=shopStatus.data.store_id;
      if(ai_template =="product" || ai_template =="cart")
      {
        function addCSS(t)
        {
          var e = document.getElementsByTagName("head")[0],
          i = document.createElement("link");
          i.href = t, i.type = "text/css", i.rel = "stylesheet", e.append(i)
        }
        addCSS(domainPath + "/front_end/css/earning_recommand_style.css");
        addCSS(domainPath + "/front_end/js/owl_slide/ai_owl.carousel.min.css");
        addCSS(domainPath + "/front_end/js/owl_slide/ai_owl.theme.default.min.css");
        AddJS("//cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js");
        function AddJS(path)
        {
          var fileref=document.createElement('script');
          fileref.setAttribute("type","text/javascript");
          fileref.setAttribute("src", path);
          document.getElementsByTagName("head")[0].appendChild(fileref);
        }

        var widgetList = {product:1,cart:4};
        var ai_page_id=widgetList[ai_template];
        //var slidecontent="<div class='eran_hero' style='width:100%; margin:0 auto;max-width:1170px;'> <div class='ai_product_recommandation_title ai_cross_sell_related_title'> <h3>Product Recommendation</h3> </div> <div class='owl-carousel owl-theme earning_grid_slider' id='ai_product_recommandation_list'> <img src='"+domainPath+"public/front_end/image/loaderNew.gif'> </div> <div class='ai_top_selling_product_title ai_cross_sell_related_title'> <h3>Product Recommendation</h3> </div> <div class='owl-carousel owl-theme earning_grid_slider' id='ai_top_selling_product_list'> <img src='"+domainPath+"public/front_end/image/loaderNew.gif'> </div> <div class='ai_newly_arrived_products_title ai_cross_sell_related_title'> <h3>Product Recommendation</h3> </div> <div class='owl-carousel owl-theme earning_grid_slider' id='ai_newly_arrived_products_list'> <img src='"+domainPath+"public/front_end/image/loaderNew.gif'> </div> </div>";
        var slidecontent="  <div class='ai_cross_sell_eran_hero' id='CrossSellNewTopProducts' style='width:100%; margin:0 auto;max-width:1170px;'> </div>";
        $("main, .main-content, #MainContent").append(slidecontent);

        var frontendStatus = $.parseJSON($.ajax({
          url:  domainPath+'/api/getProductList?store_url='+shopurl+'&ai_template='+ai_template+'&product_id='+ai_product_id+"&ai_page_id="+ai_page_id,
          dataType: "json", 
          async: false
        }).responseText);
        var layoutView="ai_grid_view";  

        if(typeof frontendStatus.data.widgets_lists_id_4 != 'undefined')
        {
          if(frontendStatus.data.widgets_lists_id_4.status == 1)
          {
            if(frontendStatus.data.layout_view == "slider")
            {
              layoutView="owl-carousel owl-theme";
            }  
            var product_r="<div class='ai_product_recommandation_title ai_cross_sell_related_title'>  <h3 "+frontendStatus.data.layout_heading_style+">"+frontendStatus.data.widgets_lists_id_4.title+"</h3></div><div class='"+layoutView+" earning_grid_slider' id='ai_product_recommandation_list'>"+frontendStatus.data.widgets_lists_id_4.product_list+"</div>";
            document.getElementById("CrossSellNewTopProducts").innerHTML +=product_r;
          }   
        } 
        $(function()
        { 
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
            var shopify_product_id=$(this).attr("shopify_product_id");
            selectedvriant = selectedvrnt.children("option:selected").val();
            var ai_product_id=$(this).attr("id");
            var prd_id=ai_product_id.split('product_');
            product_id_db=prd_id['1'];
            var ai_widget_type_data=$(this).find('a').attr("widget-type-data");
            itemclickCount(selectedvriant,ai_product_id,ai_page_id,ai_widget_type_data,product_id_db,shopify_product_id);

          });

          $('body').on("change", ".earning_variant_id", function()
          { 
            var campare_del=$(this).parents(".earning_item").find("del");
            var selectedvrnt=$(this).parents(".earning_item").find(".earning_variant_id");
            var compare_money_now=$(this).parents(".earning_item").find(".compare-price");
            var regular_money_now=$(this).parents(".earning_item").find(".regular-price");
            var layoutCurrency=frontendStatus.data.layout_currency;
            var main_price= selectedvrnt.children("option:selected").attr("main-price-data");
            var compare_price= selectedvrnt.children("option:selected").attr("compare-price-data");

            var cry_cmr = layoutCurrency.replace("@", compare_price);
            $(campare_del).hide();
            $(compare_money_now).html(cry_cmr);
            if(parseFloat(main_price) < parseFloat(compare_price)){
              $(campare_del).css("display","inline-block");   
            }
            

            var cry_main = layoutCurrency.replace("@", main_price);
            $(regular_money_now).html(cry_main);

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
        function addItemToCartEarning(variant_id, qty,ai_product_id,ai_page_id,ai_widget_type_data,product_id_db,shopify_product_id)
        {
          var  earningbtnlodr=$("body #"+ai_product_id).find(".earningbtn");
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
            url: domainPath+'/api/updateCountAddToCart',
            data: {"store_id":store_id,"widgets_page_id":ai_widget_type_data,"widgets_id":ai_widget_type_data,"product_id":product_id_db},
            success: function(data) {
            console.log(data); 

            }
          });

        }

        function itemclickCount(variant_id,ai_product_id,ai_page_id,ai_widget_type_data,product_id_db,shopify_product_id)
        {
          /*updateCountAddToCart on database*/
          jQuery.ajax({
            type: 'POST',
            url: domainPath+'/api/updateCountProductClick',
            data: {"store_id":store_id,"widgets_page_id":ai_widget_type_data,"widgets_id":ai_widget_type_data,"product_id":product_id_db},
            success: function(data) {
            //   console.log(data); 
            }
          });

          /*for add to cart in cookies*/

          for (var i in ai_cart) 
          {
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


        function aiSaveCart()
        {
          if ( window.localStorage)
          {
            localStorage.ai_cart = JSON.stringify(ai_cart);
          }
        }

        $(function() 
        { 
          var owl = $('.owl-carousel.earning_grid_slider');
          owl.owlCarousel({
          autoplay: false,
          loop: false,
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