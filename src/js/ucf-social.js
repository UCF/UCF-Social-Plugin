const socialDebounce = function (func, wait, immediate) {
  let timeout;

  return function (...args) {
    const that = this;

    const later = function () {
      timeout = null;
      if (!immediate) {
        func.apply(that, args);
      }
    };

    const callNow = immediate && !timeout;
    clearTimeout(timeout);
    timeout = setTimeout(later, wait);

    if (callNow) {
      func.apply(that, args);
    }
  };
};

const scrollToggleInit = function (elementId, callback) {
  const $window = $(window);
  const $document = $(document);
  const $element = $(`#${elementId}`);
  const debouceTime = 400;
  let offset;

  const curatorResize = function () {
    offset = $element.offset().top - $window.height() - 100;
  };

  const curatorScroll = function () {
    // check if element scrolled too
    if ($window.scrollTop() >= offset) {
      callback();

      $document.off('.curator');
      $window.off('.curator');
    }
  };

  $window.on('load.curator resize.curator', socialDebounce(curatorResize, debouceTime));
  $document.on('scroll.curator', socialDebounce(curatorScroll, debouceTime));
};
