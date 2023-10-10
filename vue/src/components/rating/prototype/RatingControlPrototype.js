export default {
  setRating: function (rating, options) {
    options = options || {};

    const WebApp = window.Telegram?.WebApp || {};
    if (!options.silent) WebApp.HapticFeedback.selectionChanged();
    if (!options.silent && !WebApp.isExpanded) WebApp.expand();

    let self = this;
    let startTime;
    let fireChange = options.fireChange || false;
    let onComplete = options.onComplete || function () {};
    let easing = options.easing || self.easings.easeInOutCubic;
    let duration = options.duration === undefined ? 550 : options.duration;
    let startXPosition = self.sliderPosition;
    let endXPosition = rating * self.selectedRatingElement.offsetWidth;

    if (duration > 0) {
      let anim = function (timestamp) {
        startTime = startTime || timestamp;
        let elapsed = timestamp - startTime;
        let progress = easing(
          elapsed,
          startXPosition,
          endXPosition - startXPosition,
          duration
        );
        self.setSliderPosition(progress);
        if (elapsed < duration) {
          requestAnimationFrame(anim);
        } else {
          self.setSliderPosition(endXPosition);
          self.setLabelTransitionEnabled(true);
          if (
            self.onRatingChange &&
            self.selectedRating !== rating &&
            fireChange
          ) {
            self.onRatingChange(rating);
          }
          onComplete();
          self.selectedRating = rating;
        }
      };

      self.setLabelTransitionEnabled(false);
      requestAnimationFrame(anim);
    } else {
      self.setSliderPosition(endXPosition);
      if (self.onRatingChange && self.selectedRating !== rating && fireChange) {
        self.onRatingChange(rating);
      }
      onComplete();
      self.selectedRating = rating;
    }
  },

  setSliderPosition: function (position) {
    let self = this;
    self.sliderPosition = Math.min(
      Math.max(0, position),
      self.containerElement.offsetWidth - self.selectedRatingElement.offsetWidth
    );
    let stepProgress =
      (self.sliderPosition / self.containerElement.offsetWidth) *
      self.ratingElements.length;
    let relativeStepProgress = stepProgress - Math.floor(stepProgress);
    let currentStep = Math.round(stepProgress);
    let startStep = Math.floor(stepProgress);
    let endStep = Math.ceil(stepProgress);
    // Move handle
    self.selectedRatingElement.style.transform =
      "translateX(" +
      (self.sliderPosition / self.selectedRatingElement.offsetWidth) * 100 +
      "%)";
    // Set face
    let startPaths = self.facePaths[startStep];
    let endPaths = self.facePaths[endStep];
    let interpolatedPaths = {};
    for (let featurePath in startPaths) {
      if (startPaths.hasOwnProperty(featurePath)) {
        let startPath = startPaths[featurePath];
        let endPath = endPaths[featurePath];
        let interpolatedPoints = self.interpolatedArray(
          startPath.digits,
          endPath.digits,
          relativeStepProgress
        );
        let interpolatedPath = self.recomposeString(
          interpolatedPoints,
          startPath.nondigits
        );
        interpolatedPaths[featurePath] = interpolatedPath;
      }
    }
    let interpolatedFill = self.interpolatedColor(
      self.ratingElements[startStep]["selectedFill"],
      self.ratingElements[endStep]["selectedFill"],
      relativeStepProgress
    );
    self.selectedRatingSVGContainer.innerHTML =
      '<svg width="55px" height="55px" viewBox="0 0 50 50"><path d="M50,25 C50,38.807 38.807,50 25,50 C11.193,50 0,38.807 0,25 C0,11.193 11.193,0 25,0 C38.807,0 50,11.193 50,25" class="base" fill="' +
      interpolatedFill +
      '"></path><path d="' +
      interpolatedPaths["mouth"] +
      '" class="mouth" fill="#655F52"></path><path d="' +
      interpolatedPaths["right-eye"] +
      '" class="right-eye" fill="#655F52"></path><path d="' +
      interpolatedPaths["left-eye"] +
      '" class="left-eye" fill="#655F52"></path></svg>';
    // Update marker icon/label
    self.ratingElements.forEach(function (element, index) {
      let adjustedProgress = 1;
      if (index === currentStep) {
        adjustedProgress =
          1 - Math.abs((stepProgress - Math.floor(stepProgress) - 0.5) * 2);
      }
      element.icon.style.transform = "scale(" + adjustedProgress + ")";
      element.label.style.transform =
        "translateY(" + self.interpolatedValue(9, 0, adjustedProgress) + "px)";
      element.label.style.color = self.interpolatedColor(
        self.labelSelectedColor,
        self.labelColor,
        adjustedProgress
      );
    });
  },

  onHandleDrag: function (e) {
    let self = this;
    e.preventDefault();
    if (e.touches) {
      e = e.touches[0];
    }
    let offset =
      self.selectedRatingElement.offsetWidth / 2 - self.handleDragOffset;
    let xPos = e.clientX - self.containerElement.getBoundingClientRect().left;
    let position = xPos - self.selectedRatingElement.offsetWidth / 2 + offset;
    self.setSliderPosition(position);
  },

  onHandleRelease: function (e) {
    let self = this;
    self.dragging = false;
    self.setLabelTransitionEnabled(true);
    let rating = Math.round(
      (self.sliderPosition / self.containerElement.offsetWidth) *
        self.ratingElements.length
    );

    self.emit("update:modelValue", rating + 1);
    self.setRating(rating, { duration: 200, fireChange: true });
  },

  setLabelTransitionEnabled: function (enabled) {
    let self = this;
    self.ratingElements.forEach(function (element) {
      if (enabled) {
        element.label.classList.remove("no-transition");
      } else {
        element.label.classList.add("no-transition");
      }
    });
  },

  interpolatedValue: function (startValue, endValue, progress) {
    return (endValue - startValue) * progress + startValue;
  },

  interpolatedArray: function (startArray, endArray, progress) {
    return startArray.map(function (startValue, index) {
      return (endArray[index] - startValue) * progress + startValue;
    });
  },

  interpolatedColor: function (startColor, endColor, progress) {
    let self = this;
    let interpolatedRGB = self
      .interpolatedArray(startColor, endColor, progress)
      .map(function (channel) {
        return Math.round(channel);
      });
    return (
      "rgba(" +
      interpolatedRGB[0] +
      "," +
      interpolatedRGB[1] +
      "," +
      interpolatedRGB[2] +
      ",1)"
    );
  },

  easeInQuint: function (t, b, c, d) {
    return c * (t /= d) * t * t + b;
  },

  hexToRGB: function (hex) {
    // Expand shorthand form to full form
    let shorthandRegex = /^#?([a-f\d])([a-f\d])([a-f\d])$/i;
    hex = hex.replace(shorthandRegex, function (m, r, g, b) {
      return r + r + g + g + b + b;
    });
    let result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
    return result
      ? [
          parseInt(result[1], 16),
          parseInt(result[2], 16),
          parseInt(result[3], 16)
        ]
      : null;
  },

  splitString: function (value) {
    let re = /-?\d*\.?\d+/g;
    let toStr = function toStr(val) {
      return typeof val === "string" ? val : String(val);
    };
    return {
      digits: toStr(value).match(re).map(Number),
      nondigits: toStr(value).split(re)
    };
  },

  recomposeString: function (digits, nondigits) {
    return nondigits.reduce(function (a, b, i) {
      return a + digits[i - 1] + b;
    });
  },

  simulateRatingTap(rating, delay, complete) {
    let self = this;
    let ratingElement = self.ratingElements[rating];
    setTimeout(function () {
      ratingElement.container.classList.add("show-touch");
      setTimeout(function () {
        ratingElement.container.classList.remove("show-touch");
        self.setRating(rating, {
          onComplete: function () {
            if (complete) {
              complete();
            }
          }
        });
      }, 250);
    }, delay || 0);
  },

  simulateRatingDrag(rating, delay, complete) {
    let self = this;
    setTimeout(function () {
      self.selectedRatingElement.classList.add("show-touch");
      setTimeout(function () {
        self.setRating(rating, {
          duration: 3000,
          easing: self.easings.easeInOutQuad,
          onComplete: function () {
            self.selectedRatingElement.classList.remove("show-touch");
            if (complete) {
              complete();
            }
          }
        });
      }, 250);
    }, delay || 0);
  }
};
