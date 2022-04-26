function SukiControlDescription( props ) {
	if ( props.children ) {
		let { ...attributes } = props;

		delete attributes.children;

		attributes.className = [ 'description', 'customize-control-description', attributes.className ].join( ' ' );

		return (
			<>
				<span {...attributes}>{props.children}</span>
			</>
		);
	} else {
		return <></>;
	}
}

export default SukiControlDescription;