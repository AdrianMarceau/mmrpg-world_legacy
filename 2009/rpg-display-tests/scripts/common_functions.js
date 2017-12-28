// Function for toggling the display of elements
function toggle_display(_container_id)
{
  _object = document.getElementById(_container_id);
  if (_object.style.display == 'none')
  {
    _object.style.display = '';
  }
  else
  {
    _object.style.display = 'none';
  }
}