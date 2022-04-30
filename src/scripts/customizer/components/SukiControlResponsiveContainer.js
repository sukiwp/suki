import classnames from 'classnames';

function SukiControlResponsiveContainer( props ) {
	return (
		<>
			<div
				className={ classnames( props.className, 'suki-responsive-container' ) }
				data-device={ props.device }
			>
				{ props.children }
			</div>
		</>
	);
}

export default SukiControlResponsiveContainer;