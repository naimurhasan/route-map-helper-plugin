<?php
namespace AAALRouteMapHelper;

!defined('ABSPATH') && exit;

require_once( plugin_dir_path( __FILE__  ).'../api/from.php' );

function route_map_helper_form_shortcode() {
    ob_start();
    ?> 
    <!-- your contents/html/(maybe in separate file to include) code etc -->
    <form name="route_map_search_form">
        <div class="mf-input-wrapper">
            <label class="mf-input-label">From </label>
            <input type="text" id="route_map_input_from" class="mf-input" required placeholder="e.g. DA1 or Heathrow Airport">
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
            <input type="text" id="route_map_input_to" class="mf-input" disabled required placeholder="Please select starting first.">
            <div class="input-results" id="to_input_results" style="">
                <ul>
                    <li>An Airport</li>
                </ul>
            </div>
        </div>
    </form>
    <script>
        
        //add jquery if not added already
        if(typeof jQuery=='undefined') {
            var headTag = document.getElementsByTagName("head")[0];
            var jqTag = document.createElement('script');
            jqTag.type = 'text/javascript';
            jqTag.src = 'http://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js';
            headTag.appendChild(jqTag);
        }

        function clog(object){
            console.log(object)
        }
        const getToListApi = "http://localhost/projects/aa_airpot_link/map-route-api?get=to&from="
        var from_input = document.getElementById("route_map_input_from")
        var from_input_result = document.getElementById("from_input_results")
        var from_list_ul = document.querySelector('#from_input_results > ul')
        var li = from_list_ul.getElementsByTagName("li");

        var to_input = document.getElementById("route_map_input_to")
        var to_list_ul = document.querySelector('#to_input_results > ul')

        var isLoadingToList = false

        // on from serach text change
        from_input.addEventListener("keyup", function(evt) {

            const searchText = evt.target.value.toUpperCase() 

            // display list if user has written anything on input
            
            if(searchText.trim() == ""){
                from_input_result.style.display = "none"
            }else{
                from_input_result.style.display = ""
            }

            var displayResultCount = 0
            for (i = 0; i < li.length; i++) {
                
                // hide everything after showing 5 results
                if(displayResultCount>4){
                    li[i].style.display = "none";
                    continue;
                }

                txtValue = li[i].textContent || li[i].innerText;
                if (txtValue.toUpperCase().indexOf(searchText) > -1) {
                    li[i].style.display = "";
                    displayResultCount++;
                } else {
                    li[i].style.display = "none";
                }
            }

        });

        
        for(var i = 0; i<li.length; i++){
            li[i].addEventListener("click", function(evt){
                var thisOptionText = evt.target.content || evt.target.innerText
                from_input.value = thisOptionText
                // console.log(thisOptionText)
                from_input_result.style.display = "none"

                // make border green
                // from_input.style.border = "1px solid green"
                fetchToInputLits(thisOptionText)
            })
        }

        /****
        ONE OPTION HAS BEEN CLICKED IN FROM INPUT
        SO WE NEED TO LOAD TO Locations
        */
        function fetchToInputLits(fromText){
            
            // show loading
            isLoadingToList = true
            showLoading()

            // send req to back end
           jQuery.get(getToListApi+fromText, function(data){
               alert('success')
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
                
           }).fail(function(jqXHR){
               alert('fail')
               
               isLoadingToList = false

               // Request failed Coudn't fetch request
               
               // make to input disabled

               // set message under from input

            //    console.log(jqXHR.responseText)
            //    console.log()
            
           })


        }

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

        // on javascript load
        jQuery(function() {
            fetchToInputLits('Heathrow%20Airport')
        });

    </script>
    <?php
  
    return ob_get_clean();
    
}
add_shortcode( 'route_map_helper_form', 'AAALRouteMapHelper\route_map_helper_form_shortcode' );

