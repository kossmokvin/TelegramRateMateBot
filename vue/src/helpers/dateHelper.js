/**
 * timeSince - Converts an absolute date into a relative date string.
 *
 * This function takes a JavaScript `Date` object and returns a string representation
 * indicating how much time has passed since that date, e.g., "2 hours ago" or "3 weeks ago".
 * The function breaks down the time difference into years, months, weeks, days, hours, minutes,
 * and seconds, and returns the largest unit of time that's greater than one.
 *
 * The calculation is based on the number of seconds in each time unit:
 * - 1 year: 31,536,000 seconds
 * - 1 month: 2,592,000 seconds (approximated as 30 days for simplicity)
 * - 1 week: 604,800 seconds
 * - 1 day: 86,400 seconds
 * - 1 hour: 3,600 seconds
 * - 1 minute: 60 seconds
 *
 * @param {Date} date - The input date for which the relative time string is to be generated.
 * @returns {string} - A string representation indicating how much time has passed since the input date.
 *
 * @example
 *
 * const date = new Date('2023-10-06 19:09:14');
 * console.log(timeSince(date)); // Might output "2 hours ago" depending on the current time.
 */
const timeSince = (date) => {
  const now = new Date();
  const seconds = Math.floor((now - date) / 1000);

  const formatTime = (value, singular, plural) => {
    return value + " " + (value === 1 ? singular : plural) + " ago";
  };

  let interval = seconds / 31536000; // 1 year has 31536000 seconds
  if (interval > 1) {
    return formatTime(Math.floor(interval), "year", "years");
  }

  interval = seconds / 2592000; // 1 month has 2592000 seconds
  if (interval > 1) {
    return formatTime(Math.floor(interval), "month", "months");
  }

  interval = seconds / 604800; // 1 week has 604800 seconds
  if (interval > 1) {
    return formatTime(Math.floor(interval), "week", "weeks");
  }

  interval = seconds / 86400; // 1 day has 86400 seconds
  if (interval > 1) {
    return formatTime(Math.floor(interval), "day", "days");
  }

  interval = seconds / 3600; // 1 hour has 3600 seconds
  if (interval > 1) {
    return formatTime(Math.floor(interval), "hour", "hours");
  }

  interval = seconds / 60; // 1 minute has 60 seconds
  if (interval > 1) {
    return formatTime(Math.floor(interval), "minute", "minutes");
  }

  if (seconds < 10) {
    return "a few seconds ago";
  }

  return formatTime(seconds, "second", "seconds");
};

export { timeSince };
