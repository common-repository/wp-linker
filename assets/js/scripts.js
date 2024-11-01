let ajaxAdmin  = wp_linker_ajax.url;
let loadingGif = wp_linker_ajax.gif;

document.addEventListener ( 'DOMContentLoaded', function () {
  let tooltips   = Array.from ( document.querySelectorAll ( 'a.tooltip-on' ) );

  if( tooltips.length > 0 ) {
    tooltips.forEach ( function ( tooltip ) {
      tooltip.addEventListener ( 'mouseenter', function ( event ) {
        renderTooltip ( tooltip );
      } );
    } );
  }
} );

function renderTooltip( tooltip ) {

  const postID = tooltip.dataset.id;

  /**
   * Load tooltip with default animation gif
   */
  const tip = new Tooltip ( '<div class="spinner"><div class="double-bounce1"></div><div class="double-bounce2"></div></div>', {
    effectClass : 'slide',
    stateClass  : 'not-good',
    baseClass   : 'ba_ks__tooltip',
  } );
  tip.position ( tooltip ).show ();

    let xhr = new XMLHttpRequest ();
    xhr.onreadystatechange = function () {

      if (this.readyState === 4 && this.status === 200) {
        const response = JSON.parse(this.response)
        tip.content(getTooltipContent(response.post));
      }
    };

  xhr.open ( 'POST', ajaxAdmin, true );
  const dataToSend = new FormData();
  dataToSend.append('action','wp_linker_ajax_handler');
  dataToSend.append('requestParams',postID);
  dataToSend.append('requestType','getPost');

  xhr.send (dataToSend);



  tooltip.addEventListener ( 'mouseleave', function ( event ) {
    tip.hide ();
  } );
}

function getTooltipContent(post)
{
    let html = '';
    html += '<div class="tooltipContent">';

    if (post.post_thumbnail !== false) {
        html += '<div class="imageHolder">';
        html += '<img src="' + post.post_thumbnail + '" alt="'+ post.post_title +'" />';
        html += '</div>';
    }

    html += '<div class="contentHolder">';
    html += '<p class="title"><a href="' + post.post_url + '">' + post.post_title + '</a></p>';
    html += '<p class="postContent">' + post.post_content + '</p>';
    html += '</div>';


    html += '</div>';


    return html;
}
