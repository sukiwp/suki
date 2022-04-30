import classnames from 'classnames';

function SukiControlLabel( props ) {
	return (
		<>
			<label
				className={ classnames( props.className, 'customize-control-title' ) }
				htmlFor={ props.for }
			>
				{ props.children }
			</label>
		</>
	);
}

export default SukiControlLabel;