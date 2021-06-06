<?php
namespace AAALRouteMapHelper;

!defined('ABSPATH') && exit;

require_once( plugin_dir_path( __FILE__  ).'../api/from.php' );

function route_map_helper_form_shortcode() {

    $route_product_id = get_option(ROUTE_MAP_OPTION_PRODUCT);

    if($route_product_id == null){
      return "<font color='red'><strong>Please set a product id in:<br/>wp-admin >> route-map-helper >> setting</strong></font>";
    }

    ob_start();
    ?> 
    <!-- your contents/html/(maybe in separate file to include) code etc -->
    <div id="route_map_search_form">
        <div class="mf-input-wrapper">
            <label class="mf-input-label">From </label>
            <input type="text" id="route_map_input_from" autocomplete="off" class="mf-input" required placeholder="e.g. DA1 or Heathrow Airport">
            <div class="input-results" id="from_input_results" style="display:none;">
                <ul>
                    <?php 
                        foreach (get_form_array() as $location_name) {
                            echo "<li>$location_name</li>";
                        }
                    ?>
                </ul>
            </div>
        </div>
       <div class="mf-input-wrapper">
            <label class="mf-input-label">To </label>
            <input type="text" id="route_map_input_to" autocomplete="off" class="mf-input" disabled required placeholder="Please select starting first.">
            <div class="input-results" id="to_input_results" style="display:none;">
                <ul>
                    
                </ul>
            </div>
        </div>
        <button id="get_a_quote_btn" class="btn-action-route-map-api">Get a quote</button>
        </div>
    <script>
        var headTag = document.getElementsByTagName('head')[0];
        /**********
        * Add jquery if not added already
        *******/
        if(typeof jQuery=='undefined') {
            
            var jqTag = document.createElement('script');
            jqTag.type = 'text/javascript';
            jqTag.src = 'http://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js';
            headTag.appendChild(jqTag);
        }

        /**********
        * SWEET ALERT
        *******/
        var swalAlert = document.createElement('script');
        swalAlert.type = 'text/javascript';
        swalAlert.src = 'https://cdn.jsdelivr.net/npm/sweetalert2@10';
        headTag.appendChild(swalAlert);

        /**********
        * POLYFILL
        *******/
        var swalPolyfill = document.createElement('script');
        swalPolyfill.type = 'text/javascript';
        swalPolyfill.src = 'https://cdn.jsdelivr.net/npm/promise-polyfill@8/dist/polyfill.js';
        headTag.appendChild(swalPolyfill);
        
        /**********
        * Variables
        ***********/
        function clog(object){
            console.log(object)
        }
        const getToListApi = '<?php echo site_url(); ?>/map-route-api?get=to&from='
        var from_input = document.getElementById('route_map_input_from')
        var from_input_result = document.getElementById('from_input_results')
        var from_list_ul = document.querySelector('#from_input_results > ul')
        var li = from_list_ul.getElementsByTagName("li");

        var to_input_result = document.getElementById('to_input_results')
        var to_input = document.getElementById('route_map_input_to')
        var to_list_ul = document.querySelector('#to_input_results > ul')
        var to_li = to_list_ul.getElementsByTagName('li');
        
        var get_a_quote_btn = document.getElementById('get_a_quote_btn') 

        var isLoadingToList = false


        /**********
        * on from serach text change
        ***********/
        from_input.addEventListener("keyup", function(evt) {

            filter_dropdown(evt.target.value, from_input_result, li)

        });

        /**********
        * on to serach text change
        ***********/
        to_input.addEventListener("keyup", function(evt){
            filter_dropdown(evt.target.value, to_input_result, to_li)
        })

        /**********
        * DROPDOWN UTILITY
        ***********/
        function filter_dropdown(value, input_result, li_element){
            const searchText = value.toUpperCase() 

            // display li_elementst if user has written anything on input
            
            if(searchText.trim() == ""){
                input_result.style.display = "none"
            }else{
                input_result.style.display = ""
            }

            var displayResultCount = 0
            for (i = 0; i < li_element.length; i++) {
                
                // hide everything after showing 5 results
                if(displayResultCount>4){
                    li_element[i].style.display = "none";
                    continue;
                }

                txtValue = li_element[i].textContent || li_element[i].innerText;
                if (txtValue.toUpperCase().indexOf(searchText) > -1) {
                    li_element[i].style.display = "";
                    displayResultCount++;
                } else {
                    li_element[i].style.display = "none";
                }
            }
        }

        /**********
        * add from list click event
        ***********/
        for(var i = 0; i<li.length; i++){
            li[i].addEventListener("click", function(evt){
                var thisOptionText = evt.target.content || evt.target.innerText
                from_input.value = thisOptionText
                // console.log(thisOptionText)
                from_input_result.style.display = "none"

                // make border green
                // from_input.style.border = "1px solid green"
                to_input.value = ""
                fetchToInputLits(encodeURI(thisOptionText))
                
            })
        }

        

        /****
        ONE OPTION HAS BEEN CLICKED IN FROM INPUT
        SO WE NEED TO LOAD 'TO' Locations
        */
        function fetchToInputLits(fromText){
            
            // show loading
            to_input.disabled = true
            isLoadingToList = true
            showLoading()

            // send req to back end
           jQuery.get(getToListApi+fromText, function(data){
               
               //    console.log(data)
               var to_locations = JSON.parse(data)
               

                // make results empty
                to_list_ul.innerHTML = ""

                // add all the result in input result list
                to_locations.forEach(function(item){
                    //    console.log(item)
                    var li = document.createElement('li');
                    li.innerText = item
                    to_list_ul.append(li)
                })

                isLoadingToList = false
                // make the to input enabled
                to_input.placeholder = "Input 'To' location."
                to_input.disabled = false

                // to list click
                for(var i = 0; i<to_li.length; i++){
                    to_li[i].addEventListener("click", function(evt){
                        var thisOptionText = evt.target.content || evt.target.innerText
                        to_input.value = thisOptionText
                        // console.log(thisOptionText)
                        to_input_result.style.display = "none"

                        // make border green
                        // from_input.style.border = "1px solid green"
                        // fetchToInputLits(thisOptionText)
                    })
                }
                
           }).fail(function(jqXHR){
            //    alert('fail')
               
               isLoadingToList = false

               // Request failed Coudn't fetch request
               
               // make to input disabled

               // set message under from input

            //    console.log(jqXHR.responseText)
            //    console.log()
            
           })


        }

        /**********
        * Loading Animation
        ***********/
        function showLoading(){
            
            if(isLoadingToList){
                var toInputText = to_input.placeholder
                
                switch(toInputText){
                   case 'Loading.':
                        to_input.placeholder = 'Loading..'
                    break;
                    case 'Loading..':
                        to_input.placeholder = 'Loading...'
                    break;
                    default:
                        to_input.placeholder = 'Loading.'
                    break;
                }
                
                setTimeout(() => {
                    showLoading()
                }, 500);

            }
        }

        /***********************
        * Get A quote Button Clicked
        ******************* */
        get_a_quote_btn.addEventListener('click', function(){
            
            // cehck if form emtpy
            const from_value = from_input.value.trim()
            const to_value = to_input.value.trim()
            
                        
            if( from_value == '' && to_value == '' ){
                
                Swal.fire({
                        icon: 'error',
                        title: 'Locations not selected',
                        text: "Please select 'from' & 'to' locations.",
                    })

            }
                // return alert

            // if not empty
            window.location.href = "<?php echo site_url(); ?>/<?php echo SELECT_CAR; ?>/?from="+encodeURI(from_value)+"&to="+encodeURI(to_value)
                // forward to next page

        })

    </script>
    <?php
  
    return ob_get_clean();
    
}
add_shortcode( 'route_map_helper_form', 'AAALRouteMapHelper\route_map_helper_form_shortcode' );

