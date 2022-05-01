/**
 * Convert dimension value (e.g. 100px) into number (e.g. 100) and unit (e.g. px) values.
 * When allowed units array were specified, the value unit will be validated.
 *
 * @param {string} rawValue     The raw value as a string (may or may not contain the unit)
 * @param {array}  allowedUnits Array of allowed units
 * @returns {array} Array of 2 items, number and unit derived from the raw value.
 */
export function convertDimensionValueIntoNumberAndUnit( rawValue, allowedUnits = [] ) {
	let value = String( rawValue );

	// Fetch number from the rawValue.
	let number = parseFloat( value );
	
	// Check if number is valid (finite number).
	number = isFinite( number ) ? number : undefined;

	// Fetch unit from the value.
	let unit = value.replace( number, '' );

	// Check if unit is valid (one of the allowedUnits).
	if ( Array.isArray( allowedUnits ) && 0 < allowedUnits.length ) {
		let unitObj = allowedUnits.find( ( item ) => {
			return unit === item.value;
		} );

		// Use the matched unit. If not, use the first item of allowedUnits.
		unit = unitObj?.value || allowedUnits[0].value;
	}

	return [ number, unit ];
}