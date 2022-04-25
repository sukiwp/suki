function SukiControlLabel( props ) {
	if ( props.text ) {
		return (
			<>
				<label htmlFor={props.for} className='customize-control-title'>{props.text}</label>
			</>
		);
	} else {
		return <></>;
	}
}

export default SukiControlLabel;