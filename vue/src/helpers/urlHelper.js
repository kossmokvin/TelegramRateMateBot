/**
 * queryStringToObject - Converts a query string into an object representation.
 *
 * This function takes a URL-encoded query string (usually the part after the "?" in a URL)
 * and converts it into an object, where each key-value pair in the query string becomes a property-value
 * pair in the returned object.
 *
 * Additionally, this function attempts to parse each value with `JSON.parse()` to handle cases where
 * the value might be a serialized JSON string. If parsing fails, it defaults to using the raw string value.
 *
 * The function performs the following steps:
 * 1. Decodes the query string using `decodeURIComponent` to handle URL-encoded characters.
 * 2. Splits the decoded string into key-value pairs using the '&' delimiter.
 * 3. Iterates over each key-value pair:
 *    a. Splits the pair into a key and a value using the '=' delimiter.
 *    b. Attempts to parse the value with `JSON.parse()`.
 *    c. If parsing fails, uses the raw string value.
 *    d. Adds the key and value to the result object.
 *
 * @param {string} queryString - The URL-encoded query string to be converted.
 * @returns {Object} - An object representation of the query string, with properties and values derived from the key-value pairs in the query string.
 *
 * @example
 *
 * const query = "name=John&age=25&preferences=%7B%22theme%22%3A%22dark%22%7D";
 * console.log(queryStringToObject(query));
 * // Outputs: { name: "John", age: "25", preferences: { theme: "dark" } }
 */
const queryStringToObject = (queryString) => {
  const decodedString = decodeURIComponent(queryString);
  const pairs = decodedString.split("&");

  let result = {};

  pairs.forEach((pair) => {
    const [key, _value] = pair.split("=");
    let value;
    try {
      value = JSON.parse(_value);
    } catch {
      value = _value;
    }
    result[key] = value;
  });

  return result;
};

export { queryStringToObject };
