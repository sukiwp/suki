function SukiControlLabel( props ) {
	if ( props.children ) {
		let { ...attributes } = props;

		attributes.className = [ 'customize-control-title', attributes.className ].join( ' ' );

		attributes.htmlFor = '_customize-input-' + attributes.id;

		delete attributes.id;

		return (
			<>
				<label { ...attributes }>{ props.children }</label>
			</>
		);
	} else {
		return <></>;
	}
}

export default SukiControlLabel;