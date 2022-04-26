function SukiControlLabel( props ) {
	if ( props.children ) {
		let { ...attributes } = props;

		delete attributes.children;

		attributes.className = [ 'customize-control-title', attributes.className ].join( ' ' );

		return (
			<>
				<label {...attributes}>{props.children}</label>
			</>
		);
	} else {
		return <></>;
	}
}

export default SukiControlLabel;