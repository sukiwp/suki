<?php
/**
 * Static Fonts class
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

class Suki_Customizer_Sanitization {
	/**
	 * Sanitize Select value
	 *
	 * @param string $value
	 * @param WP_Customize_Setting $setting
	 * @return string
	 */
	public static function select( $value, $setting ) {
		// Ensure input is a slug.
		$value = sanitize_key( $value );
		
		// Get the control object associated with the setting.
		$control = $setting->manager->get_control( $setting->id );
		
		// If the input is a valid key, return it;
		// otherwise, return the default.
		return array_key_exists( $value, $control->choices ) ? $value : '';
	}

	/**
	 * Sanitize Textarea value
	 *
	 * @param string $value
	 * @param WP_Customize_Setting $setting
	 * @return string
	 */
	public static function textarea( $value, $setting ) {
		return sanitize_textarea_field( $value );
	}

	/**
	 * Sanitize Toggle value
	 *
	 * @param mixed $value
	 * @param WP_Customize_Setting $setting
	 * @return integer
	 */
	public static function toggle( $value, $setting ) {
		return ( 1 === absint( $value ) ) ? 1 : 0;
	}

	/**
	 * Sanitize Color value
	 *
	 * @param string $value
	 * @param WP_Customize_Setting $setting
	 * @return string
	 */
	public static function color( $value, $setting ) {
		return self::validate_color( $value );
	}

	/**
	 * Sanitize Number value
	 *
	 * @param integer|float $value
	 * @param WP_Customize_Setting $setting
	 * @return integer|float
	 */
	public static function number( $value, $setting ) {
		$value = floatval( $value );

		// Get the control object associated with the setting.
		$control = $setting->manager->get_control( $setting->id );

		// Validate value.
		$value = self::validate_number( $value, $control->input_attrs );

		return $value;
	}

	/**
	 * Sanitize Slider value
	 *
	 * @param string $value
	 * @param WP_Customize_Setting $setting
	 * @return string
	 */
	public static function slider( $value, $setting ) {
		// Get the control object associated with the setting.
		$control = $setting->manager->get_control( $setting->id );

		// Validate value.
		$value = self::validate_dimension( $value, $control->units );

		return $value;
	}

	/**
	 * Sanitize Dimensions value
	 *
	 * @param string $value
	 * @param WP_Customize_Setting $setting
	 * @return string
	 */
	public static function dimensions( $value, $setting ) {
		// Check if there is no value in top, right, bottom, left properties, then return empty string (without unit).
		if ( '' === trim( $value ) ) {
			return '';
		}

		// Elaborate each property.
		// Check if properties count is less than 4, return empty string.
		$props = explode( ' ', $value );
		if ( 4 > count( $props ) ) {
			return '';
		}

		// Get the control object associated with the setting.
		$control = $setting->manager->get_control( $setting->id );

		// Validate each property.
		for ( $i = 0; $i < count( $props ); $i++ ) {
			$props[ $i ] = self::validate_dimension( $props[ $i ], $control->units );
		}

		// Build new value.
		$value = implode( ' ', $props );

		return $value;
	}

	/**
	 * Sanitize Typography value.
	 *
	 * @param string $value
	 * @param WP_Customize_Setting $setting
	 * @return string
	 */
	public static function typography( $value, $setting ) {
		if ( '' === $value || 'inherit' === $value ) {
			return $value;
		}

		$valid_id = preg_match( '/(.*?)_(font_family|font_weight|font_style|text_transform|font_size|line_height|letter_spacing)/', $setting->id, $matches );

		// Check if setting id is invalid, return empty string.
		if ( ! $valid_id ) {
			return '';
		}

		// Get element & type.
		$control_id = $matches[1] . '_typography';
		$type = $matches[2];

		// Get the control object associated with the setting.
		$control = $setting->manager->get_control( $control_id );

		switch ( $type ) {
			case 'font_family':
				$choices = isset( $control->choices[ $type ] ) ? $control->choices[ $type ] : array();

				// Check if value format is invalid, then return empty string.
				if ( false === strpos( $value, '|' ) ) {
					return '';
				}

				$chunks = explode( '|', $value );

				// Check if provider is invalid, then return empty string.
				if ( ! array_key_exists( $chunks[0], $choices ) ) {
					return '';
				}

				// Check if font family is invalid, then return empty string.
				if ( ! array_key_exists( $value, $choices[ $chunks[0] ] ) ) {
					return '';
				}
				break;

			case 'font_weight':
			case 'font_style':
			case 'text_transform':
				$choices = isset( $control->choices[ $type ] ) ? $control->choices[ $type ] : array();

				// Make sure the selected value in one of the available choices.
				if ( ! array_key_exists( $value, $choices ) ) {
					return '';
				}
				break;
			
			case 'font_size':
			case 'line_height':
			case 'letter_spacing':
				$units_data = isset( $control->units[ $type ] ) ? $control->units[ $type ] : array();

				// Validate dimension
				$value = self::validate_dimension( $value, $units_data );

				break;
		}

		return $value;
	}

	/**
	 * Sanitize Shadow value.
	 *
	 * @param string $value
	 * @param WP_Customize_Setting $setting
	 * @return string
	 */
	public static function shadow( $value, $setting ) {
		// Elaborate each property.
		$props = explode( ' ', $value );

		// Check if properties count is less than 4, return empty string.
		if ( 5 > count( $props ) ) {
			return '';
		}

		foreach ( $props as $i => $prop ) {
			switch ( $i ) {
				case 4:
					// Validate
					$props[ $i ] = self::validate_color( $props[ $i ] );
					break;
				
				default:
					// Validate dimension.
					$props[ $i ] = self::validate_dimension( $props[ $i ], array( 'px' => array() ) );
					break;
			}
		}

		return $value;
	}

	/**
	 * Sanitize Builder value.
	 *
	 * @param array $value
	 * @param WP_Customize_Setting $setting
	 * @return array
	 */
	public static function multiselect( $value, $setting ) {
		// Ensure input is an array.
		$value = (array) $value;
		
		// Get the control object associated with the setting.
		$control = $setting->manager->get_control( $setting->id );

		foreach ( $value as $slug ) {
			if ( ! array_key_exists( $slug, $control->choices ) ) {
				unset( $value[ $i ] );
			}
		}
		
		return array_values( $value );
	}

	/**
	 * Sanitize HTML value.
	 *
	 * @param string $value
	 * @param WP_Customize_Setting $setting
	 * @return string
	 */
	public static function html( $value, $setting ) {
		return wp_kses_post( $value );
	}

	/**
	 * Sanitize Builder value.
	 *
	 * @param array $value
	 * @param WP_Customize_Setting $setting
	 * @return array
	 */
	public static function builder( $value, $setting ) {
		// Ensure input is an array
		$value = (array) $value;

		$valid_id = preg_match( '/(.*?)_((?:top|main|bottom|vertical).*)/', $setting->id, $matches );

		// Check if setting id is invalid, return empty array.
		if ( ! $valid_id ) {
			return array();
		}

		// Get element & type.
		$control_id = $matches[1];
		$location = $matches[2];
		
		// Get the control object associated with the setting.
		$control = $setting->manager->get_control( $control_id );

		foreach ( $value as $slug ) {
			if ( ! array_key_exists( $slug, $control->choices ) ) {
				unset( $value[ $i ] );
			}

			$avoided_locations = isset( $control->avoid[ $slug ] ) ? $control->avoid[ $slug ] : array();
			if ( array_key_exists( $location, $control->avoid ) ) {
				unset( $value[ $i ] );
			}
		}
		
		return array_values( $value );
	}
	/**
	 * Wrapper function to validate color value.
	 *
	 * @param string $color
	 * @return string
	 */
	private static function validate_color( $color ) {
		if ( preg_match( '/#([a-fA-F0-9]){3}(([a-fA-F0-9]){3})?\b/', $color ) || preg_match( '/rgba?\((\d+),\s*(\d+),\s*(\d+)(?:,\s*(\d+(?:\.\d+)?))?\)/', $color ) ) {
			return $color;
		} else {
			return '';
		}
	}

	/**
	 * Wrapper function to validate number value.
	 *
	 * @param string $number
	 * @param array $range
	 * @return string
	 */
	private static function validate_number( $number, $range ) {
		if ( ! is_numeric( $number ) ) {
			return '';
		}

		$step = ( isset( $range['step'] ) ? $range['step'] : 1 );
		$min = ( isset( $range['min'] ) ? $range['min'] : $number );
		$max = ( isset( $range['max'] ) ? $range['max'] : $number );

		if ( preg_match( '/\d*?\.(\d*)/', $step, $matches ) ) {
			$decimal_count = strlen( $matches[1] );
		} else {
			$decimal_count = 0;
		}

		// Make sure the number is divisible by the step value.
		if ( ! is_int( $number / $step ) ) {
			$number = round( $number / $step, $decimal_count ) * $step;
		}

		// Make sure the number is not smaller than min value.
		if ( isset( $min ) && $number < $min ) {
			$number = $min;
		}

		// Make sure the number is not higher than max value.
		if ( isset( $max ) && $number > $max ) {
			$number = $max;
		}

		return $number;
	}

	/**
	 * Wrapper function to validate dimension (number + unit) value.
	 *
	 * @param string $dimension
	 * @param array $available_units
	 * @return string
	 */
	private static function validate_dimension( $dimension, $available_units ) {
		// Explode value to number and unit.
		$dimension_number = floatval( $dimension );
		$dimension_unit = str_replace( $dimension_number, '', $dimension );

		// Check if no number found, then return empty string (without unit).
		if ( $dimension_unit === $dimension ) {
			return '';
		}

		// Check if selected unit is invalid, then return empty string (without unit).
		if ( ! array_key_exists( $dimension_unit, $available_units ) ) {
			return '';
		}

		// Get selected unit data.
		$selected_unit = $available_units[ $dimension_unit ];

		// Validate the number value.
		$dimension_number = self::validate_number( $dimension_number, $selected_unit );

		// Check if number is invalid, then return empty string (without unit).
		if ( empty( $dimension_number ) ) {
			return '';
		}

		// Build new value.
		$dimension = $dimension_number . $dimension_unit;

		return $dimension;
	}
}