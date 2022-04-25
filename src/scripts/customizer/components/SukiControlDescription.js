function SukiControlDescription( props ) {
	if ( props.text ) {
		return (
			<>
				<span id={props.id} className="description customize-control-description">{props.text}</span>
			</>
		);
	} else {
		return <></>;
	}
}

export default SukiControlDescription;