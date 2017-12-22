// Create the prototype battle options object
var battleOptions = {};
// When the document is ready, assign events
$(document).ready(function(){
  
  // Define the prototype context
  var thisContext = $('#prototype');
  if (thisContext.length){
    
    // Define the action for the data link
    $('.banner .data', thisContext).click(function(e){
      // Prevent the default click action
      e.preventDefault();
      // Redirect the user to the data index
      window.location = 'data/index.php?type=robot'; 
      });
    
    // Define the confirmation event for the reset action
    $('.banner .reset', thisContext).click(function(e){
      // Prevent the default click action
      e.preventDefault();
      // Define the confirmation text string
      var confirmText = 'Are you sure you want to reset your game?\nAll progress will be lost and cannot be restored.';
      // Attempt to confirm with the user of they want to resey
      if (confirm(confirmText)){
        // Redirect the user to the prototype reset page
        var postURL = 'prototype.php?action=reset';
        $.post(postURL, function(){ 
          window.location = 'prototype.php';  
          });        
        return true;
        } else {
        // Return false
        return false;
        }
      });    
    
    // Create click events for the battle redirect links
    $('a[data-redirect]', thisContext).click(function(e){
      e.preventDefault();
      var thisRedirect = $(this).attr('data-redirect');
      if (thisRedirect.length){
        window.location.href = thisRedirect;
        return true;
        } else {
        return false;
        }
      });
      
    /*
    // Automatically preload all option and sprite background images
    $('.option,.sprite', thisContext).each(function(){
      var thisBackgroundImage = $(this).css('background-image');
      thisBackgroundImage = thisBackgroundImage.replace(/^url\("(.*?)"\)$/i, '$1');
      $.preLoadImages(thisBackgroundImage);
      //alert(thisBackgroundImage);
      });
    */
      
    // Create the click events for the prototype menu option buttons
    $('.option[data-token]', thisContext).click(function(e){
      
      // Prevent the default click action
      e.preventDefault();
      
      // If this option is disabled, ignore its input
      if ($(this).hasClass('option_disabled')
        && !$(this).hasClass('option_disabled_clickable')
        ){ return false; }
        
      // Collect the parent menu and option fields
      var thisParent = $(this).parent();
      if (thisParent.is('.option_wrapper')){ thisParent = thisParent.parent(); }
      var thisStep = parseInt(thisParent.attr('data-step'));
      var thisSelect = thisParent.attr('data-select');
      var thisToken = $(this).attr('data-token');
      var nextStep = $('.menu[data-step='+(thisStep + 1)+']', thisContext);
      var nextFlag = true;
      var nextLimit = parseInt($(this).attr('data-next-limit'));
      
      // If the token was empty, return false
      if (!thisToken.length){ return false; }
      
      // If the next limit was set, apply to the next step
      if (nextLimit != undefined){
        nextStep.attr('data-limit', nextLimit);
        }
      
      // If this is a child token, update the parent
      if ($(this).attr('data-child') != undefined){
        
        // Find the parent token container
        var tokenParent = $('.option[data-parent]', $(this).parent());
        var tokenParentLimit = thisParent.attr('data-limit');
        var tokenParentValue = tokenParent.attr('data-token');
        
        // Append this token to the parent's
        tokenParent.attr('data-token', tokenParentValue+(tokenParentValue.length ? ',' : '')+thisToken);
        tokenParentValue = tokenParent.attr('data-token');
        // Add the disabled class to this element
        $(this).addClass('option_disabled');
        // Count the number of elements in the parent token
        var tokenParentCount = tokenParentValue.split(',').length;
        
        // Create a clone of this option's sprite element
        var someValue = (tokenParentLimit * 40) - (tokenParentCount * 40) + 40;
        var cloneShift = someValue+'px';
        var cloneSprite = $('.sprite', this).clone().css({left:cloneShift,right:'auto',bottom:'6px'});
        
        // Prepend the sprite to the parent's label value
        $('label', tokenParent).append(cloneSprite);
        
        // Hide the placeholder appropriate sprite
        $('.sprite_40x40_placeholder:eq('+(tokenParentCount - 1)+')', tokenParent).css({display:'none'});
        
        // Brighten the opacity of the parent element proportionately
        var newOpacity = 0.2 + (0.8 * (tokenParentCount/tokenParentLimit));
        tokenParent.css({opacity:newOpacity});
        tokenParent.find('.count').html((tokenParentCount >= tokenParentLimit) ? 'Start!' : (tokenParentCount+'/'+tokenParentLimit));
        tokenParent.find('.arrow').html('&#9658;');
                
        // Check if we've reached the token limit
        if (tokenParentCount >= tokenParentLimit){
          // Disable all other child options and enable the parent
          $('.option[data-child]', thisParent).addClass('option_disabled');
          tokenParent.removeClass('option_disabled');
          }
        
        // Set the next flag to false to prevent menu switching
        nextFlag = false;
        
        } else {
        
        // Update the battleOptions object with the current selection
        battleOptions[thisSelect] = thisToken;
        
        }
      
      // Execute option-specific commands for special cases
      switch (thisSelect){
        case 'this_player_token': {
          
          // Prevent the player from fighting themselves in battle
          var tempCondition = 'this_player_token='+battleOptions['this_player_token'];
          var tempMenu = $('.menu[data-select=this_battle_token]', thisContext);
          $('.option_wrapper[data-condition!="'+tempCondition+'"]', tempMenu).css({display:'none'});
         
          break;
          }
        case 'this_battle_token': {
          
          // Prevent the player from fighting themselves in battle
          var tempCondition = 'this_player_token='+battleOptions['this_player_token'];
          var tempMenu = $('.menu[data-select=this_player_robots]', thisContext);
          var tempWrapper = $('.option_wrapper[data-condition!="'+tempCondition+'"]', tempMenu);
          tempWrapper.css({display:'none'});
          
          // Find the parent token container
          var tempWrapper = $('.option_wrapper[data-condition="'+tempCondition+'"]', tempMenu);
          var tokenParent = $('.option[data-parent]', tempWrapper);
          var tokenParentLimit = tempMenu.attr('data-limit');
          
          //alert('tokenParentLimit '+tokenParentLimit);
          
          // Generate the placeholder sprite markup
          var iCounter = 1;
          var spriteMarkup = '';
          for (iCounter; iCounter <= nextLimit; iCounter++){
            var someValue = (tokenParentLimit * 40) - (iCounter * 40) + 40;
            var spriteClass = 'sprite sprite_40x40 sprite_40x40_defend sprite_40x40_placeholder ';
            var spriteStyle = 'background-image: url(images/robots/robot/sprite_right_40x40.png?'+gameSettings.cacheTime+'); bottom: 6px; left: '+someValue+'px; right: auto; opacity: 0.8; ';
            spriteMarkup += '<span class="'+spriteClass+'" style="'+spriteStyle+'">Select Robot</span>';
            }
          
          // Prepend the sprite to the parent's label value
          var labelPadding = ((tokenParentLimit * 40)+60)+'px';
          $('.sprite_40x40_placeholder', tokenParent).remove();
          $('label', tokenParent).css({paddingLeft:labelPadding}).prepend(spriteMarkup);
          
          break;
          }
        default: {
          
          break;
          }
        }
        
      // Only do banner events for non-child options
      if ($(this).attr('data-child') == undefined){
        
        // Collect the context for the banner area and remove and foregrounds
        var thisBanner = $('.banner', thisContext);
        $('.credits:not(.is_shifted)', thisBanner).animate({opacity:0.0},{duration:600,easing:'swing',sync:false,complete:function(){ 
          $(this).addClass('is_shifted'); 
          }});
        $('.foreground:not(.is_shifted)', thisBanner).animate({opacity:0.25},{duration:600,easing:'swing',sync:false,complete:function(){
          $(this).addClass('is_shifted');   
          }});
        
        // Count the number of other options in the banner
        var numOptions = $('.option', thisBanner).length;
        
        // Remove any options for the same select parent
        var previousOption = $('.option[data-select='+thisSelect+']', thisBanner);
        if (previousOption.length){
          previousOption.animate({opacity:0},600,'swing',function(){ 
            $('.option:gt('+previousOption.eq()+')', thisBanner).remove();
            $(this).remove();           
            });
          numOptions--;
          }
        
        // Determine the position of this new option block
        var thisPosition = numOptions + 1;
        
        // Append this option object to the main banner window
        var cloneOption = $(this).clone();
        cloneOption.attr('data-select', thisSelect);
        cloneOption.removeClass('option_1x1 option_1x2 option_1x3 option_1x4').addClass('option_1x'+thisPosition);
        cloneOption.css({
          position:'absolute',
          zIndex:40,
          left:'-30px',
          top:(10 + (78 * numOptions))+'px',
          opacity:0,
          marginLeft:'-'+(thisBanner.outerWidth() + 100)+'px',
          borderWidth:'1px',
          width:((thisPosition * 20) + 10)+'%'
          });
        cloneOption.find('label').css({
          marginRight:'15px',
          width:'120px'
          });
        cloneOption.unbind('click');
        thisBanner.append(cloneOption);
        cloneOption.animate({opacity:1,marginLeft:'0'},600,'linear');
        
      }     
      
      // Collect the preload image list, if provided
      var thisPreload = $(this).attr('data-preload')  !== undefined ? $(this).attr('data-preload') : false;
      
      // Collect all the redirect variables in case they're needed
      var thisRedirect = 'battle.php?wap='+(gameSettings.wapFlag ? 'true' : 'false');
      for (var key in battleOptions){ thisRedirect += '&'+key+'='+battleOptions[key]; }
      
      // Check if image preloading was requested
      if (thisPreload.length){
        // Preload the requested image
        var thisPreloadImage = $(document.createElement('img'))
          .attr('src', thisPreload)
          .load(function(){
            // Check if there is another menu step to complete
            if (nextStep.length){
              // Automatically switch to the next step in sequence
              prototype_menu_switch({stepNumber:thisStep + 1});
              } else {
              // Redirect to the battle page
              prototype_menu_switch({redirectLink:thisRedirect}); // checkpoint
              }
            });
        } else if (nextFlag != false){
        // Check if there is another menu step to complete
        if (nextStep.length){
          // Automatically switch to the next step in sequence
          prototype_menu_switch({stepNumber:thisStep + 1});
          } else {
          // Redirect to the battle page
          prototype_menu_switch({redirectLink:thisRedirect});
          }
        }
      
      // Return true on success
      return true;
      
      });
    
    // Create the click events for the prototype menu back button
    $('.option[data-back]', thisContext).click(function(e){
      // Prevent the default click action
      e.preventDefault();
      // Collect the parent menu and option fields
      var backStep = parseInt($(this).attr('data-back'));
      var backParent = $('.menu[data-step='+(backStep)+']', thisContext);
      var backSelect = backParent.attr('data-select');
      // Clear the previous battleOption selection
      delete battleOptions[backSelect];
      // Define the switchOptions object
      var switchOptions = {stepNumber:backStep,autoSkip:'false',slideDirection:'right'};
      // Execute option-specific commands for special cases
      switch (backSelect){
        case 'this_player_token': {
          switchOptions.onComplete = function(){
            // Re-enable all battle options
            var tempMenu = $('.menu[data-select=this_battle_token]', thisContext);
            $('.option_wrapper[data-condition]', tempMenu).css({display:''});
            delete battleOptions['this_battle_token'];
            }
          break;
          }
        case 'this_battle_token': {
          switchOptions.onComplete = function(){
            // Re-enable all battle options
            var tempMenu = $('.menu[data-select=this_player_robots]', thisContext);
            $('.option_wrapper[data-condition]', tempMenu).css({display:''});
            $('.option[data-child]', tempMenu).removeClass('option_disabled');
            $('.option[data-parent]', tempMenu).addClass('option_disabled').attr('data-token', '').css({opacity:''}).find('.count').html('&nbsp;').end().find('.arrow').html('&nbsp;');
            $('.option[data-parent] label', tempMenu).css({paddingLeft:''});
            $('.option[data-parent] .sprite:not(.sprite_40x40_placeholder)', tempMenu).remove();
            $('.sprite_40x40_placeholder', tempMenu).css({display:''});
            delete battleOptions['this_player_robots'];
            }
          break;
          }
        default: {
          break;
          }
        }
      // Clear any of this select's options in the banner
      var thisBanner = $('.banner', thisContext);
      $('.option[data-select='+backSelect+']', thisBanner).animate({opacity:0},600,'swing',function(){
        $(this).remove();
          var remainingOptions = $('.option', thisBanner).length;
          //alert(remainingOptions);
          if (remainingOptions < 1){
            //alert('no options');
            $('.is_shifted', thisBanner).removeClass('is_shifted').animate({opacity:1.0},600,'swing');
            }  
        });      
      
      // Trigger the menu switch for the new step
      prototype_menu_switch(switchOptions);
      });
    
      // Check if the player token has already been selected
      if (battleOptions['this_player_token'] != undefined){
        //alert('player selected : '+battleOptions['this_player_token']);
        var thisMenu = $('.menu[data-select="this_player_token"]', thisContext);
        $('.option[data-token="'+battleOptions['this_player_token']+'"]', thisMenu).trigger('click');
      }
    
      // Fade in the battle screen slowly
      thisContext.waitForImages(function(){
        var tempTimeout = setTimeout(function(){
          thisContext.css({opacity:0}).removeClass('hidden').animate({opacity:1.0}, 800, 'swing');
          }, 1000);
        }, false, true);        
    
    }
  
});

// Create a function for switching to a specific menu step
function prototype_menu_switch(switchOptions){
  // Redefine the options array populating defaults
  switchOptions = {
    stepNumber: switchOptions.stepNumber || false,
    redirectLink: switchOptions.redirectLink || false,
    autoSkip: switchOptions.autoSkip || 'false',
    slideDirection: switchOptions.slideDirection || 'left',
    onComplete: switchOptions.onComplete || function(){}
    };
  // DEBUG
  //alert('Switching to '+switchOptions.stepNumber+'\nAuto Skip is '+(switchOptions.autoSkip == 'true' ? 'ON' : 'OFF'));
  // Define the prototype context
  var thisContext = $('#prototype');
  if (thisContext.length){
    // Define the animation properties
    var slideOutAnimation = {opacity:0};
    var slideInAnimation = {opacity:0};
    if (switchOptions.slideDirection == 'left'){
      slideOutAnimation.marginLeft = '-1000px';
      slideOutAnimation.marginRight = '1000px';
      slideInAnimation.marginLeft = '1000px';
      slideInAnimation.marginRight = '-1000px';
      } else if (switchOptions.slideDirection == 'right'){
      slideOutAnimation.marginRight = '-1000px';
      slideOutAnimation.marginLeft = '1000px';
      slideInAnimation.marginRight = '1000px';
      slideInAnimation.marginLeft = '-1000px';
      }
    // Automatically fade-out the previous menu screen
    $('.menu[data-step]:not(.menu_hide)', thisContext).animate(slideOutAnimation, 600, 'swing', function(){
      // Once the menu is faded, remove it from display
      $(this).addClass('menu_hide').css({opacity:0,marginLeft:'0',marginRight:'0'});
      // Check if the stepNumber is numeric or not
      if (switchOptions.stepNumber !== false){
        // Collect the main banner title
        var thisBanner = $('.banner', thisContext);
        var thisBannerTitle = thisBanner.attr('title');
        // Collect a reference to the current menus
        var thisMenu = $('.menu[data-step='+switchOptions.stepNumber+']', thisContext);
        var thisMenuTitle = thisMenu.attr('data-title');
        // Update the banner text with this menu subtitle
        $('.title', thisBanner).html(thisBannerTitle+' : '+thisMenuTitle);
        // Check how many choices are available
        var thisMenuChoices = $('.option[data-token]:not(.option_disabled)', thisMenu);
        //alert('Menu choices : '+thisMenuChoices.length);
        // Check if there is only one menu-choice available and skip is enabled
        if (switchOptions.autoSkip == 'true' && thisMenuChoices.length <= 1){
          //alert('Auto Skip triggered...');
          // Secretly unhide the current menu and auto-click the only available option
          thisMenu.css({opacity:0}).removeClass('menu_hide');
          thisMenuChoices.eq(0).trigger('click');
          } else {
          // Unhide the current menu so the user can pick
          thisMenu.css(slideInAnimation).removeClass('menu_hide').animate({opacity:1.0,marginLeft:'0',marginRight:'0'}, 400, 'swing');
          }
        } else if (switchOptions.redirectLink !== false){
        // Fade the prototype out of view and redirect on completion
        thisContext.animate({opacity:0}, 500, 'swing', function(){
          // Loop through all battle options and generate request data
          var requestType = 'session';
          var requestData = '';
          for (optionToken in battleOptions){
            // Collect the option token and value
            var thisOptionToken = optionToken;
            var thisOptionValue = battleOptions[optionToken];
            // Generate the request data and post it to the server
            requestData += 'battle_settings,'+thisOptionToken+','+thisOptionValue+';';
            }
          // Post the generated request data to the server and wait for a reply
          $.post('scripts/script.php',{requestType:requestType,requestData:requestData},function(data){
            //alert(data);
            // Execute the onComplete function
            switchOptions.onComplete();                                  
            // Redirect to the string location passed as the stepNumber
            window.location.href = switchOptions.redirectLink;            
            });
          });
        }
        // Execute the onComplete function
        switchOptions.onComplete();
      });
    }
}