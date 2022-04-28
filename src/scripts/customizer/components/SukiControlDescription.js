function SukiControlDescription( props ) {
	if ( props.children ) {
		let { ...attributes } = props;

		attributes.className = [ 'description', 'customize-control-description', attributes.className ].join( ' ' );

		attributes.id = '_customize-description-' + attributes.id;

		return (
			<>
				<span { ...attributes }>{ props.children }</span>
			</>
		);
	} else {
		return <></>;
	}
}

export default SukiControlDescription;