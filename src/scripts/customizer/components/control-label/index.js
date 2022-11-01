import './index.scss';

import classnames from 'classnames';

const SukiControlLabel = ( { children, className, target } ) => {
	return (
		<>
			<label
				className={ classnames( className, 'customize-control-title' ) }
				htmlFor={ target }
			>
				{ children }
			</label>
		</>
	);
};

export default SukiControlLabel;
