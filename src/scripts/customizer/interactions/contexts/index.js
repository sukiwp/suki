import './index.scss';

wp.customize.bind( 'ready', () => {
	Object.keys( sukiCustomizerData.contexts ).forEach( ( elementId ) => {
		const elementType = 0 === elementId.indexOf( 'suki_section' ) ? 'section' : 'control';

		wp.customize[ elementType ]( elementId, ( elementObj ) => {
			const setVisibility = function() {
				// Get the control / section container.
				let elementContainer = elementObj.container;
				if ( 'section' === elementType ) {
					elementContainer = elementObj.headContainer;
				}

				// Check all rules.
				let allRulesMatched = true;
				sukiCustomizerData.contexts[ elementId ].forEach( ( rule ) => {
					const settingObj = '__device' === rule.setting ? wp.customize.previewedDevice : wp.customize( rule.setting );

					// Skip if rule setting object is not found.
					if ( undefined === settingObj ) {
						return;
					}

					// Get rule setting value.
					const checkedValue = settingObj.get();

					// Check rule based on its operator.
					let ruleMatched;
					switch ( rule.operator ) {
						case '>':
							ruleMatched = checkedValue > rule.value;
							break;

						case '<':
							ruleMatched = checkedValue < rule.value;
							break;

						case '>=':
							ruleMatched = checkedValue >= rule.value;
							break;

						case '<=':
							ruleMatched = checkedValue <= rule.value;
							break;

						case 'in':
							ruleMatched = 0 <= rule.value.indexOf( checkedValue );
							break;

						case 'not_in':
							ruleMatched = 0 > rule.value.indexOf( checkedValue );
							break;

						case 'contain':
							ruleMatched = 0 <= checkedValue.indexOf( rule.value );
							break;

						case 'not_contain':
							ruleMatched = 0 > checkedValue.indexOf( rule.value );
							break;

						case '!=':
							ruleMatched = checkedValue !== rule.value;
							break;

						case 'empty':
							ruleMatched = 0 === checkedValue.length;
							break;

						case '!empty':
							ruleMatched = 0 < checkedValue.length;
							break;

						default:
							ruleMatched = checkedValue === rule.value;
							break;
					}

					// Merge each rule result to the final result.
					allRulesMatched = allRulesMatched && ruleMatched;
				} );

				// Set visibility.
				if ( allRulesMatched ) {
					elementContainer.removeClass( 'suki-context--hidden' );
				} else {
					elementContainer.addClass( 'suki-context--hidden' );

					if ( 'section' === elementType && elementObj.expanded() ) {
						elementObj.collapse();
					}
				}
			};

			// Bind each setting in the rules.
			sukiCustomizerData.contexts[ elementId ].forEach( ( rule ) => {
				const settingObj = '__device' === rule.setting ? wp.customize.previewedDevice : wp.customize( rule.setting );

				if ( undefined !== settingObj ) {
					// Bind the setting for future use.
					settingObj.bind( setVisibility );
				}
			} );

			// Initial run.
			setVisibility();
		} );
	} );
} );
