import classnames from 'classnames';

function SukiControlDescription( { children, className, id } ) {
	return (
		<>
			<span
				className={ classnames( className, 'description', 'customize-control-description' ) }
				id={ id }
			>
				{ children }
			</span>
		</>
	);
}

export default SukiControlDescription;