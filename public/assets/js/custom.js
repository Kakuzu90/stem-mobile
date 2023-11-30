const dropDown = $('.dropdown-filter')[0];
const container = $('.dropdown-filter-container')[0];
const close = $('.dropdown-close');

close.on('click', function(event) {
  event.stopPropagation();
});


close.on('click', function() {
  dropDown.classList.remove('show');
  container.classList.remove('show');
});

$(document).on('click', function(event) {
  const isDropDown = event.target.matches('.dropdown-filter-toggle') || event.target.closest('.dropdown-filter') || event.target.matches('.dropdown-filter-container');
  if (!isDropDown) {
    dropDown.classList.remove('show');
    container.classList.remove('show');
  }
});

$(document).on('click', '.dropdown-filter-toggle',function() {
  dropDown.classList.toggle('show');
  container.classList.toggle('show');
});