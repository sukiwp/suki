import classnames from 'classnames';

function SukiControlDescription( props ) {
	return (
		<>
			<span
				className={ classnames( props.className, 'description', 'customize-control-description' ) }
				id={ props.id }
			>
				{ props.children }
			</span>
		</>
	);
}

export default SukiControlDescription;