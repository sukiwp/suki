function SukiControlRespnsiveGroup( props ) {
	if ( props.children ) {
		let { ...attributes } = props;

		attributes.className = [ 'suki-control-responsive-group', attributes.className ].join( ' ' );

		return (
			<>
				<div { ...attributes }>{ props.children }</div>
			</>
		);
	} else {
		return <></>;
	}
}

export default SukiControlRespnsiveGroup;